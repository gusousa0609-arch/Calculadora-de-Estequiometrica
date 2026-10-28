/**
 * Motor Químico e Estequiométrico EstequioLab
 * Cálculos de Balanceamento, Massa Molar, Proporções, Titulação, Concentração, Nox
 * Reconhecimento de Subscritos (quantidades de moléculas) e Sobrescritos (Nox / Cargas)
 * Explicações simplificadas e limpas (sem excesso de caracteres ou LaTeX poluído)
 */

const AVOGADRO_CONSTANT = 6.02214076e23;
const MOLAR_VOLUME_CNTP = 22.414; // Litros por mol nas CNTP (0°C, 1 atm)

// Mapeamento de Subscritos (quantidades de átomos/moléculas)
const SUBSCRIPT_TO_NORMAL = {
    '₀': '0', '₁': '1', '₂': '2', '₃': '3', '₄': '4',
    '₅': '5', '₆': '6', '₇': '7', '₈': '8', '₉': '9'
};

// Mapeamento de Sobrescritos (cargas iônicas e números de oxidação - Nox)
const SUPERSCRIPT_TO_NORMAL = {
    '⁰': '0', '¹': '1', '²': '2', '³': '3', '⁴': '4',
    '⁵': '5', '⁶': '6', '⁷': '7', '⁸': '8', '⁹': '9',
    '⁺': '+', '⁻': '-'
};

/**
 * Normaliza fórmulas químicas:
 * 1. Converte subscritos (H₂O -> H2O) para contagem de átomos/moléculas.
 * 2. Detecta e extrai sobrescritos (Fe³⁺, SO₄²⁻) identificando a carga/Nox informada.
 * @param {string} formula
 * @returns {Object} { normalized, noxDetected, original }
 */
function normalizeFormula(formula) {
    if (!formula || typeof formula !== "string") {
        return { normalized: "", noxDetected: null, original: "" };
    }

    let str = formula.trim().replace(/\[/g, "(").replace(/\]/g, ")");
    const original = str;

    // Detecta sobrescritos de Nox / carga iônica (ex: ³⁺, ⁺³, ²⁻, ⁻², ⁺, ⁻)
    let noxDetected = null;
    const superRegex = /([⁰¹²³⁴⁵⁶⁷⁸⁹⁺⁻]+)$/;
    const match = str.match(superRegex);

    if (match) {
        let chargeStr = match[1].split('').map(ch => SUPERSCRIPT_TO_NORMAL[ch] || ch).join('');
        if (chargeStr === '+') noxDetected = 1;
        else if (chargeStr === '-') noxDetected = -1;
        else if (chargeStr.endsWith('+')) noxDetected = parseInt(chargeStr.replace('+', ''), 10) || 1;
        else if (chargeStr.endsWith('-')) noxDetected = -(parseInt(chargeStr.replace('-', ''), 10) || 1);
        else if (chargeStr.startsWith('+')) noxDetected = parseInt(chargeStr.replace('+', ''), 10) || 1;
        else if (chargeStr.startsWith('-')) noxDetected = -(parseInt(chargeStr.replace('-', ''), 10) || 1);
        else if (/^\d+$/.test(chargeStr)) noxDetected = parseInt(chargeStr, 10);

        str = str.replace(superRegex, '').trim();
    }

    // Converte números subscritos para normais (quantidade atômica)
    str = str.split('').map(ch => SUBSCRIPT_TO_NORMAL[ch] || ch).join('');

    return {
        normalized: str,
        noxDetected: noxDetected,
        original: original
    };
}

/**
 * Parser de Fórmulas Químicas
 * Suporta subscritos (H₂O), sobrescritos (Fe³⁺), parênteses Ca(OH)₂ e fórmulas clássicas
 */
function parseFormula(formula) {
    if (!formula || typeof formula !== "string") {
        throw new Error("Fórmula química inválida ou vazia.");
    }

    const { normalized, noxDetected } = normalizeFormula(formula);
    let clean = normalized;

    function parseGroup(str) {
        let counts = {};
        let i = 0;

        while (i < str.length) {
            if (str[i] === "(") {
                let depth = 1;
                let j = i + 1;
                while (j < str.length && depth > 0) {
                    if (str[j] === "(") depth++;
                    if (str[j] === ")") depth--;
                    j++;
                }
                if (depth !== 0) {
                    throw new Error("Parênteses desbalanceados na fórmula química.");
                }
                const subStr = str.substring(i + 1, j - 1);
                
                let numStr = "";
                while (j < str.length && /\d/.test(str[j])) {
                    numStr += str[j];
                    j++;
                }
                const mult = numStr ? parseInt(numStr, 10) : 1;
                const subCounts = parseGroup(subStr);

                for (let elem in subCounts) {
                    counts[elem] = (counts[elem] || 0) + subCounts[elem] * mult;
                }
                i = j;
            } else if (/[A-Z]/.test(str[i])) {
                let elem = str[i];
                i++;
                if (i < str.length && /[a-z]/.test(str[i])) {
                    elem += str[i];
                    i++;
                }
                let numStr = "";
                while (i < str.length && /\d/.test(str[i])) {
                    numStr += str[i];
                    i++;
                }
                const count = numStr ? parseInt(numStr, 10) : 1;
                counts[elem] = (counts[elem] || 0) + count;
            } else if (/\s/.test(str[i])) {
                i++;
            } else {
                throw new Error(`Caractere inesperado na fórmula: '${str[i]}'`);
            }
        }
        return counts;
    }

    const counts = parseGroup(clean);
    
    // Valida elementos existentes
    for (let s in counts) {
        const found = findElement(s);
        if (!found) {
            throw new Error(`Elemento desconhecido '${s}' na fórmula informada.`);
        }
    }

    return {
        counts: counts,
        normalized: normalized,
        noxDetected: noxDetected
    };
}

/**
 * Calcula a Massa Molar de uma substância
 */
function calculateMolarMass(formula) {
    const parsed = parseFormula(formula);
    const counts = parsed.counts;
    let totalMass = 0;
    const composition = [];

    for (let sym in counts) {
        const elem = findElement(sym);
        const count = counts[sym];
        const elemTotalMass = count * elem.m;
        totalMass += elemTotalMass;
        composition.push({
            symbol: sym,
            name: elem.n,
            count: count,
            atomicMass: elem.m,
            subtotalMass: elemTotalMass
        });
    }

    composition.forEach(item => {
        item.percentage = (item.subtotalMass / totalMass) * 100;
    });

    return {
        formula: formula,
        normalized: parsed.normalized,
        noxDetected: parsed.noxDetected,
        molarMass: totalMass,
        counts: counts,
        composition: composition
    };
}

/**
 * Calcula o Número de Oxidação (Nox) dos elementos de uma fórmula
 * Reconhece cargas/Nox digitados como sobrescrito (ex: Fe³⁺, SO₄²⁻)
 */
function calculateNox(formula) {
    const parsed = parseFormula(formula);
    const counts = parsed.counts;
    const elements = Object.keys(counts);
    const noxMap = {};
    const noxDetected = parsed.noxDetected;

    // Se o usuário digitou um único elemento com sobrescrito (ex: Fe³⁺, Ca²⁺, Cl⁻)
    if (elements.length === 1 && noxDetected !== null) {
        noxMap[elements[0]] = noxDetected;
        const sign = noxDetected > 0 ? `+${noxDetected}` : `${noxDetected}`;
        return {
            formula: formula,
            noxMap: noxMap,
            noxDetected: noxDetected,
            explanation: `Nox identificado diretamente pelo sobrescrito: ${sign}.`
        };
    }

    // Se for substância simples sem carga (ex: O₂, H₂, Fe)
    if (elements.length === 1 && noxDetected === null) {
        noxMap[elements[0]] = 0;
        return {
            formula: formula,
            noxMap: noxMap,
            noxDetected: 0,
            explanation: `Substância simples: o Nox de qualquer elemento em substância simples é 0.`
        };
    }

    // Carga total esperada da molécula ou íon (0 para neutras, ou noxDetected se for íon)
    const targetTotalCharge = noxDetected !== null ? noxDetected : 0;

    let knownSum = 0;

    elements.forEach(sym => {
        if (["Li", "Na", "K", "Rb", "Cs", "Fr"].includes(sym)) {
            noxMap[sym] = 1;
            knownSum += 1 * counts[sym];
        } else if (["Be", "Mg", "Ca", "Sr", "Ba", "Ra", "Zn"].includes(sym)) {
            noxMap[sym] = 2;
            knownSum += 2 * counts[sym];
        } else if (sym === "Al") {
            noxMap[sym] = 3;
            knownSum += 3 * counts[sym];
        } else if (sym === "Ag") {
            noxMap[sym] = 1;
            knownSum += 1 * counts[sym];
        } else if (sym === "F") {
            noxMap[sym] = -1;
            knownSum += -1 * counts[sym];
        }
    });

    if ("H" in counts && !(noxMap["H"])) {
        const hasMetalOnly = elements.every(e => e === "H" || ["Li", "Na", "K", "Ca", "Mg", "Ba"].includes(e));
        if (hasMetalOnly && elements.length === 2) {
            noxMap["H"] = -1;
            knownSum += -1 * counts["H"];
        } else {
            noxMap["H"] = 1;
            knownSum += 1 * counts["H"];
        }
    }

    if ("O" in counts && !(noxMap["O"])) {
        const remainingExceptO = elements.filter(e => !(e in noxMap) && e !== "O");
        if (remainingExceptO.length > 0) {
            noxMap["O"] = -2;
            knownSum += -2 * counts["O"];
        }
    }

    const remaining = elements.filter(e => !(e in noxMap));
    
    if (remaining.length === 1) {
        const unk = remaining[0];
        const unkCount = counts[unk];
        // knownSum + unkCount * Nox = targetTotalCharge
        const targetNox = (targetTotalCharge - knownSum) / unkCount;
        noxMap[unk] = Number.isInteger(targetNox) ? targetNox : Number(targetNox.toFixed(2));
    } else if (remaining.length > 1) {
        const e1 = findElement(remaining[0]);
        const e2 = findElement(remaining[1]);
        if (e1 && e2) {
            const negNox = e1.en > e2.en ? (e1.g === 17 ? -1 : -2) : (e2.g === 17 ? -1 : -2);
            if (e1.en > e2.en) {
                noxMap[e1.s] = negNox;
                noxMap[e2.s] = (targetTotalCharge - (negNox * counts[e1.s] + knownSum)) / counts[e2.s];
            } else {
                noxMap[e2.s] = negNox;
                noxMap[e1.s] = (targetTotalCharge - (negNox * counts[e2.s] + knownSum)) / counts[e1.s];
            }
        }
    }

    return {
        formula: formula,
        noxMap: noxMap,
        noxDetected: noxDetected,
        explanation: noxDetected !== null
            ? `Íon composto com carga total ${noxDetected > 0 ? '+' + noxDetected : noxDetected}. As somas das cargas parciais fecham exatamente a carga do íon.`
            : `Molécula neutra: a soma algébrica das cargas de todos os átomos é igual a 0.`
    };
}

/**
 * Balanceador de Equações Químicas
 * Suporta subscritos (H₂ + O₂ -> H₂O) e números convencionais
 */
function balanceEquation(eqStr) {
    if (!eqStr || (!eqStr.includes("=") && !eqStr.includes("->") && !eqStr.includes("→"))) {
        throw new Error("Digite uma reação química com reagentes e produtos separados por '->' ou '='. Exemplo: H2 + O2 -> H2O ou H₂ + O₂ → H₂O");
    }

    const separator = eqStr.includes("->") ? "->" : (eqStr.includes("→") ? "→" : "=");
    const parts = eqStr.split(separator);
    if (parts.length !== 2) {
        throw new Error("A reação deve conter um lado para reagentes e um lado para produtos.");
    }

    const splitMolecules = (sideStr) => {
        return sideStr.split("+").map(s => s.trim()).filter(s => s.length > 0).map(item => {
            const match = item.match(/^(\d+)\s*(.+)$/);
            return match ? match[2].trim() : item;
        });
    };

    const reactantMolecules = splitMolecules(parts[0]);
    const productMolecules = splitMolecules(parts[1]);

    if (reactantMolecules.length === 0 || productMolecules.length === 0) {
        throw new Error("Reagentes ou produtos vazios.");
    }

    const allElementsSet = new Set();
    const reactantCounts = reactantMolecules.map(f => {
        const c = parseFormula(f).counts;
        Object.keys(c).forEach(el => allElementsSet.add(el));
        return c;
    });

    const productCounts = productMolecules.map(f => {
        const c = parseFormula(f).counts;
        Object.keys(c).forEach(el => allElementsSet.add(el));
        return c;
    });

    const allElements = Array.from(allElementsSet);

    const nR = reactantMolecules.length;
    const nP = productMolecules.length;
    const totalSpecies = nR + nP;

    let solutionCoeffs = null;

    function findCoefficients(idx, currentCoeffs) {
        if (solutionCoeffs) return;

        if (idx === totalSpecies) {
            let balanced = true;
            for (let el of allElements) {
                let leftCount = 0;
                for (let i = 0; i < nR; i++) {
                    leftCount += (reactantCounts[i][el] || 0) * currentCoeffs[i];
                }
                let rightCount = 0;
                for (let j = 0; j < nP; j++) {
                    rightCount += (productCounts[j][el] || 0) * currentCoeffs[nR + j];
                }
                if (leftCount !== rightCount) {
                    balanced = false;
                    break;
                }
            }
            if (balanced) {
                solutionCoeffs = [...currentCoeffs];
            }
            return;
        }

        const maxTry = (totalSpecies <= 4) ? 14 : 8;
        for (let c = 1; c <= maxTry; c++) {
            currentCoeffs[idx] = c;
            findCoefficients(idx + 1, currentCoeffs);
            if (solutionCoeffs) return;
        }
    }

    findCoefficients(0, new Array(totalSpecies).fill(1));

    if (!solutionCoeffs) {
        throw new Error("Não foi possível balancear automaticamente. Verifique se os elementos químicos dos dois lados são idênticos.");
    }

    const reactants = reactantMolecules.map((f, i) => ({
        formula: f,
        coeff: solutionCoeffs[i],
        molarMass: calculateMolarMass(f).molarMass
    }));

    const products = productMolecules.map((f, i) => ({
        formula: f,
        coeff: solutionCoeffs[nR + i],
        molarMass: calculateMolarMass(f).molarMass
    }));

    const formatTerm = (c, f) => (c === 1 ? f : `${c} ${f}`);
    const balancedEqStr = reactants.map(r => formatTerm(r.coeff, r.formula)).join(" + ") + " → " +
                          products.map(p => formatTerm(p.coeff, p.formula)).join(" + ");

    return {
        reactants: reactants,
        products: products,
        allSpecies: [...reactants, ...products],
        balancedEquation: balancedEqStr
    };
}

/**
 * Cálculos estequiométricos de proporção
 */
function solveFullStoichiometry(balancedData, knownSpeciesIndex, knownQuantityType, knownValue) {
    if (knownValue <= 0 || isNaN(knownValue)) {
        throw new Error("Informe um valor numérico positivo para o cálculo.");
    }

    const targetSpecies = balancedData.allSpecies[knownSpeciesIndex];
    if (!targetSpecies) {
        throw new Error("Substância selecionada não encontrada.");
    }

    let molesTarget = 0;
    switch (knownQuantityType) {
        case "mols":
            molesTarget = knownValue;
            break;
        case "massa":
            molesTarget = knownValue / targetSpecies.molarMass;
            break;
        case "volume":
            molesTarget = knownValue / MOLAR_VOLUME_CNTP;
            break;
        case "particulas":
            molesTarget = knownValue / AVOGADRO_CONSTANT;
            break;
        default:
            throw new Error(`Tipo de quantidade desconhecido: ${knownQuantityType}`);
    }

    const reactionExtent = molesTarget / targetSpecies.coeff;

    const speciesResults = balancedData.allSpecies.map((sp, idx) => {
        const moles = reactionExtent * sp.coeff;
        const mass = moles * sp.molarMass;
        const volume = moles * MOLAR_VOLUME_CNTP;
        const particles = moles * AVOGADRO_CONSTANT;

        return {
            formula: sp.formula,
            coeff: sp.coeff,
            molarMass: sp.molarMass,
            moles: moles,
            mass: mass,
            volume: volume,
            particles: particles,
            isReagent: idx < balancedData.reactants.length
        };
    });

    return {
        balancedEquation: balancedData.balancedEquation,
        knownSpecies: targetSpecies,
        knownType: knownQuantityType,
        knownValue: knownValue,
        reactionExtent: reactionExtent,
        results: speciesResults
    };
}

/**
 * Titulação Ácido-Base
 */
function calculateTitration(va, ca, vb, cb, propA = 1, propB = 1) {
    let solvedVar = null;
    let solvedVal = null;
    let steps = [];

    if (!ca && va && vb && cb) {
        solvedVal = (cb * vb * propA) / (va * propB);
        solvedVar = "Concentração do Ácido (Ca)";
        steps.push(`Fórmula: Ca · Va / a = Cb · Vb / b`);
        steps.push(`Ca = (${cb} · ${vb} · ${propA}) / (${va} · ${propB}) = ${solvedVal.toFixed(4)} mol/L`);
    } else if (!va && ca && vb && cb) {
        solvedVal = (cb * vb * propA) / (ca * propB);
        solvedVar = "Volume do Ácido (Va)";
        steps.push(`Va = (${cb} · ${vb} · ${propA}) / (${ca} · ${propB}) = ${solvedVal.toFixed(4)}`);
    } else if (!cb && va && ca && vb) {
        solvedVal = (ca * va * propB) / (vb * propA);
        solvedVar = "Concentração da Base (Cb)";
        steps.push(`Cb = (${ca} · ${va} · ${propB}) / (${vb} · ${propA}) = ${solvedVal.toFixed(4)} mol/L`);
    } else if (!vb && va && ca && cb) {
        solvedVal = (ca * va * propB) / (cb * propA);
        solvedVar = "Volume da Base (Vb)";
        steps.push(`Vb = (${ca} · ${va} · ${propB}) / (${cb} · ${propA}) = ${solvedVal.toFixed(4)}`);
    } else {
        throw new Error("Deixe exatamente um dos campos em branco para ser calculado.");
    }

    return { variable: solvedVar, value: solvedVal, steps: steps };
}

/**
 * Concentração Molar e Comum
 */
function calculateConcentration(massG, molarMass, volumeL) {
    if (volumeL <= 0) throw new Error("O volume deve ser maior que zero.");
    const moles = massG / molarMass;
    const molarity = moles / volumeL;
    const common = massG / volumeL;
    return { moles, molarity, commonConcentration: common };
}

/**
 * Gerador de Explicações Didáticas Simplificadas
 * Sem caracteres poluídos, LaTeX excessivo ou fórmulas confusas.
 */
function generateExplanations(calculationType, data) {
    let objective = "";
    let kids = "";

    if (calculationType === "estequiometria") {
        const known = data.knownSpecies;
        const qtyLabel = data.knownType === "massa" ? "gramas (g)" : (data.knownType === "mols" ? "mols" : data.knownType);

        // Explicação Objetiva (Limpa e Direta)
        objective += `Reação Balanceada:\n`;
        objective += `${data.balancedEquation}\n\n`;

        objective += `Passo a Passo do Cálculo:\n`;
        objective += `1. Proporção em Mols:\n`;
        data.results.forEach(r => {
            objective += `   • ${r.formula}: ${r.coeff} mol (${r.isReagent ? 'reage' : 'produz'})\n`;
        });

        objective += `\n2. Quantidade Inicial Informada:\n`;
        objective += `   • Você inseriu ${data.knownValue} ${qtyLabel} de ${known.formula}.\n`;
        objective += `   • Isso equivale a ${ (data.reactionExtent * known.coeff).toFixed(4) } mol de ${known.formula}.\n`;

        objective += `\n3. Regra de Três Aplicada:\n`;
        objective += `   • Multiplicamos a proporção base de cada substância pelo fator da reação (${data.reactionExtent.toFixed(4)}).\n`;

        objective += `\n4. Valores Finais Calculados:\n`;
        data.results.forEach(r => {
            objective += `   • ${r.formula}: ${r.moles.toFixed(3)} mol  |  ${r.mass.toFixed(2)} g  |  ${r.volume.toFixed(2)} L (CNTP)\n`;
        });

        // Explicação para Crianças de até 11 anos (Simples, Lúdica e Curta)
        kids += `🎈 Receitinha dos Bloquinhos de LEGO!\n\n`;
        kids += `• Pense nos átomos como pecinhas mágicas de brinquedo!\n`;
        kids += `• Para fazer a mágica acontecer, desmontamos as pecinhas do começo e montamos peças novinhas no final.\n`;
        kids += `• Regra de ouro da natureza: nenhuma pecinha pode se perder e nenhuma pode sumir do nada!\n`;
        kids += `• Com os ${data.knownValue} que você colocou de ${known.formula}, deu para montar certinho cada um dos novos compostos sem sobrar nenhuma pecinha! 🚀`;

    } else if (calculationType === "massa_molar") {
        objective += `Massa Molar de ${data.formula}:\n\n`;
        data.composition.forEach(c => {
            objective += `• ${c.name} (${c.symbol}): ${c.count} átomo(s) x ${c.atomicMass.toFixed(2)} = ${c.subtotalMass.toFixed(2)} g/mol (${c.percentage.toFixed(1)}%)\n`;
        });
        objective += `\nMassa Total: ${data.molarMass.toFixed(3)} g/mol.\n`;
        objective += `Isso significa que 1 mol desta substância pesa exatamente ${data.molarMass.toFixed(2)} gramas.`;

        if (data.noxDetected !== null) {
            objective += `\nCarga / Nox informado pelo sobrescrito: ${data.noxDetected > 0 ? '+' + data.noxDetected : data.noxDetected}.`;
        }

        // Crianças
        kids += `🧺 Pesando a Cestinha de Frutas!\n\n`;
        kids += `• Imagine que a molécula ${data.formula} é uma cestinha com várias frutas diferentes.\n`;
        data.composition.forEach(c => {
            kids += `• Tem ${c.count} frutinha(s) de ${c.name}.\n`;
        });
        kids += `• Colocando tudo na balança mágica, o peso completo deu ${data.molarMass.toFixed(2)} gramas! 🍎`;

    } else if (calculationType === "nox") {
        objective += `Números de Oxidação (Nox) de ${data.formula}:\n\n`;
        for (let sym in data.noxMap) {
            const elem = findElement(sym);
            const val = data.noxMap[sym];
            const sign = val > 0 ? `+${val}` : `${val}`;
            objective += `• ${elem ? elem.n : sym} (${sym}): Nox = ${sign}\n`;
        }
        objective += `\n${data.explanation}`;

        // Crianças
        kids += `⚡ O Jogo dos Elétrons!\n\n`;
        kids += `• Os átomos estão brincando de cabo de guerra com bolinhas de energia chamadas elétrons.\n`;
        kids += `• Quem puxa mais forte fica com pontinho negativo (-).\n`;
        kids += `• Quem empresta a bolinha fica com pontinho positivo (+).\n`;
        kids += `• No final, todos os times ficaram em paz e equilibrados! 🕊️`;
    }

    return { objective, kids };
}
