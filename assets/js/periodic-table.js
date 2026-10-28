/**
 * Base de Dados Completa dos Elementos Químicos e Lógica da Tabela Periódica
 * Dados baseados em padrões internacionais da IUPAC
 */

const ELEMENTS_DATA = [
    { z: 1, s: "H", n: "Hidrogênio", m: 1.008, g: 1, p: 1, c: "nao-metal", en: 2.20, nox: "+1, -1", cfg: "1s¹", st: "Gasoso" },
    { z: 2, s: "He", n: "Hélio", m: 4.0026, g: 18, p: 1, c: "gas-nobre", en: null, nox: "0", cfg: "1s²", st: "Gasoso" },
    
    { z: 3, s: "Li", n: "Lítio", m: 6.94, g: 1, p: 2, c: "metal-alcalino", en: 0.98, nox: "+1", cfg: "[He] 2s¹", st: "Sólido" },
    { z: 4, s: "Be", n: "Berílio", m: 9.0122, g: 2, p: 2, c: "alcalino-terroso", en: 1.57, nox: "+2", cfg: "[He] 2s²", st: "Sólido" },
    { z: 5, s: "B", n: "Boro", m: 10.81, g: 13, p: 2, c: "semimetal", en: 2.04, nox: "+3", cfg: "[He] 2s² 2p¹", st: "Sólido" },
    { z: 6, s: "C", n: "Carbono", m: 12.011, g: 14, p: 2, c: "nao-metal", en: 2.55, nox: "+4, +2, -4", cfg: "[He] 2s² 2p²", st: "Sólido" },
    { z: 7, s: "N", n: "Nitrogênio", m: 14.007, g: 15, p: 2, c: "nao-metal", en: 3.04, nox: "-3, +3, +5, +4, +2", cfg: "[He] 2s² 2p³", st: "Gasoso" },
    { z: 8, s: "O", n: "Oxigênio", m: 15.999, g: 16, p: 2, c: "nao-metal", en: 3.44, nox: "-2, -1", cfg: "[He] 2s² 2p⁴", st: "Gasoso" },
    { z: 9, s: "F", n: "Flúor", m: 18.998, g: 17, p: 2, c: "halogenio", en: 3.98, nox: "-1", cfg: "[He] 2s² 2p⁵", st: "Gasoso" },
    { z: 10, s: "Ne", n: "Neônio", m: 20.180, g: 18, p: 2, c: "gas-nobre", en: null, nox: "0", cfg: "[He] 2s² 2p⁶", st: "Gasoso" },

    { z: 11, s: "Na", n: "Sódio", m: 22.990, g: 1, p: 3, c: "metal-alcalino", en: 0.93, nox: "+1", cfg: "[Ne] 3s¹", st: "Sólido" },
    { z: 12, s: "Mg", n: "Magnésio", m: 24.305, g: 2, p: 3, c: "alcalino-terroso", en: 1.31, nox: "+2", cfg: "[Ne] 3s²", st: "Sólido" },
    { z: 13, s: "Al", n: "Alumínio", m: 26.982, g: 13, p: 3, c: "metal-pos-transicao", en: 1.61, nox: "+3", cfg: "[Ne] 3s² 3p¹", st: "Sólido" },
    { z: 14, s: "Si", n: "Silício", m: 28.085, g: 14, p: 3, c: "semimetal", en: 1.90, nox: "+4, -4", cfg: "[Ne] 3s² 3p²", st: "Sólido" },
    { z: 15, s: "P", n: "Fósforo", m: 30.974, g: 15, p: 3, c: "nao-metal", en: 2.19, nox: "+5, +3, -3", cfg: "[Ne] 3s² 3p³", st: "Sólido" },
    { z: 16, s: "S", n: "Enxofre", m: 32.06, g: 16, p: 3, c: "nao-metal", en: 2.58, nox: "-2, +4, +6", cfg: "[Ne] 3s² 3p⁴", st: "Sólido" },
    { z: 17, s: "Cl", n: "Cloro", m: 35.45, g: 17, p: 3, c: "halogenio", en: 3.16, nox: "-1, +1, +3, +5, +7", cfg: "[Ne] 3s² 3p⁵", st: "Gasoso" },
    { z: 18, s: "Ar", n: "Argônio", m: 39.948, g: 18, p: 3, c: "gas-nobre", en: null, nox: "0", cfg: "[Ne] 3s² 3p⁶", st: "Gasoso" },

    { z: 19, s: "K", n: "Potássio", m: 39.098, g: 1, p: 4, c: "metal-alcalino", en: 0.82, nox: "+1", cfg: "[Ar] 4s¹", st: "Sólido" },
    { z: 20, s: "Ca", n: "Cálcio", m: 40.078, g: 2, p: 4, c: "alcalino-terroso", en: 1.00, nox: "+2", cfg: "[Ar] 4s²", st: "Sólido" },
    { z: 21, s: "Sc", n: "Escândio", m: 44.956, g: 3, p: 4, c: "metal-transicao", en: 1.36, nox: "+3", cfg: "[Ar] 3d¹ 4s²", st: "Sólido" },
    { z: 22, s: "Ti", n: "Titânio", m: 47.867, g: 4, p: 4, c: "metal-transicao", en: 1.54, nox: "+4, +3, +2", cfg: "[Ar] 3d² 4s²", st: "Sólido" },
    { z: 23, s: "V", n: "Vanádio", m: 50.942, g: 5, p: 4, c: "metal-transicao", en: 1.63, nox: "+5, +4, +3, +2", cfg: "[Ar] 3d³ 4s²", st: "Sólido" },
    { z: 24, s: "Cr", n: "Cromo", m: 51.996, g: 6, p: 4, c: "metal-transicao", en: 1.66, nox: "+3, +6, +2", cfg: "[Ar] 3d⁵ 4s¹", st: "Sólido" },
    { z: 25, s: "Mn", n: "Manganês", m: 54.938, g: 7, p: 4, c: "metal-transicao", en: 1.55, nox: "+2, +4, +7, +3, +6", cfg: "[Ar] 3d⁵ 4s²", st: "Sólido" },
    { z: 26, s: "Fe", n: "Ferro", m: 55.845, g: 8, p: 4, c: "metal-transicao", en: 1.83, nox: "+2, +3", cfg: "[Ar] 3d⁶ 4s²", st: "Sólido" },
    { z: 27, s: "Co", n: "Cobalto", m: 58.933, g: 9, p: 4, c: "metal-transicao", en: 1.88, nox: "+2, +3", cfg: "[Ar] 3d⁷ 4s²", st: "Sólido" },
    { z: 28, s: "Ni", n: "Níquel", m: 58.693, g: 10, p: 4, c: "metal-transicao", en: 1.91, nox: "+2, +3", cfg: "[Ar] 3d⁸ 4s²", st: "Sólido" },
    { z: 29, s: "Cu", n: "Cobre", m: 63.546, g: 11, p: 4, c: "metal-transicao", en: 1.90, nox: "+2, +1", cfg: "[Ar] 3d¹⁰ 4s¹", st: "Sólido" },
    { z: 30, s: "Zn", n: "Zinco", m: 65.38, g: 12, p: 4, c: "metal-transicao", en: 1.65, nox: "+2", cfg: "[Ar] 3d¹⁰ 4s²", st: "Sólido" },
    { z: 31, s: "Ga", n: "Gálio", m: 69.723, g: 13, p: 4, c: "metal-pos-transicao", en: 1.81, nox: "+3", cfg: "[Ar] 3d¹⁰ 4s² 4p¹", st: "Sólido" },
    { z: 32, s: "Ge", n: "Germânio", m: 72.630, g: 14, p: 4, c: "semimetal", en: 2.01, nox: "+4, +2", cfg: "[Ar] 3d¹⁰ 4s² 4p²", st: "Sólido" },
    { z: 33, s: "As", n: "Arsênio", m: 74.922, g: 15, p: 4, c: "semimetal", en: 2.18, nox: "+5, +3, -3", cfg: "[Ar] 3d¹⁰ 4s² 4p³", st: "Sólido" },
    { z: 34, s: "Se", n: "Selênio", m: 78.971, g: 16, p: 4, c: "nao-metal", en: 2.55, nox: "-2, +4, +6", cfg: "[Ar] 3d¹⁰ 4s² 4p⁴", st: "Sólido" },
    { z: 35, s: "Br", n: "Bromo", m: 79.904, g: 17, p: 4, c: "halogenio", en: 2.96, nox: "-1, +1, +5", cfg: "[Ar] 3d¹⁰ 4s² 4p⁵", st: "Líquido" },
    { z: 36, s: "Kr", n: "Criptônio", m: 83.798, g: 18, p: 4, c: "gas-nobre", en: 3.00, nox: "0, +2", cfg: "[Ar] 3d¹⁰ 4s² 4p⁶", st: "Gasoso" },

    { z: 37, s: "Rb", n: "Rubídio", m: 85.468, g: 1, p: 5, c: "metal-alcalino", en: 0.82, nox: "+1", cfg: "[Kr] 5s¹", st: "Sólido" },
    { z: 38, s: "Sr", n: "Estrôncio", m: 87.62, g: 2, p: 5, c: "alcalino-terroso", en: 0.95, nox: "+2", cfg: "[Kr] 5s²", st: "Sólido" },
    { z: 39, s: "Y", n: "Ítrio", m: 88.906, g: 3, p: 5, c: "metal-transicao", en: 1.22, nox: "+3", cfg: "[Kr] 4d¹ 5s²", st: "Sólido" },
    { z: 40, s: "Zr", n: "Zircônio", m: 91.224, g: 4, p: 5, c: "metal-transicao", en: 1.33, nox: "+4", cfg: "[Kr] 4d² 5s²", st: "Sólido" },
    { z: 41, s: "Nb", n: "Nióbio", m: 92.906, g: 5, p: 5, c: "metal-transicao", en: 1.6, nox: "+5, +3", cfg: "[Kr] 4d⁴ 5s¹", st: "Sólido" },
    { z: 42, s: "Mo", n: "Molibdênio", m: 95.95, g: 6, p: 5, c: "metal-transicao", en: 2.16, nox: "+6, +4, +3", cfg: "[Kr] 4d⁵ 5s¹", st: "Sólido" },
    { z: 43, s: "Tc", n: "Tecnécio", m: 98, g: 7, p: 5, c: "metal-transicao", en: 1.9, nox: "+7, +4", cfg: "[Kr] 4d⁵ 5s²", st: "Sólido" },
    { z: 44, s: "Ru", n: "Rutênio", m: 101.07, g: 8, p: 5, c: "metal-transicao", en: 2.2, nox: "+3, +4, +8", cfg: "[Kr] 4d⁷ 5s¹", st: "Sólido" },
    { z: 45, s: "Rh", n: "Ródio", m: 102.91, g: 9, p: 5, c: "metal-transicao", en: 2.28, nox: "+3", cfg: "[Kr] 4d⁸ 5s¹", st: "Sólido" },
    { z: 46, s: "Pd", n: "Paládio", m: 106.42, g: 10, p: 5, c: "metal-transicao", en: 2.20, nox: "+2, +4", cfg: "[Kr] 4d¹⁰", st: "Sólido" },
    { z: 47, s: "Ag", n: "Prata", m: 107.87, g: 11, p: 5, c: "metal-transicao", en: 1.93, nox: "+1", cfg: "[Kr] 4d¹⁰ 5s¹", st: "Sólido" },
    { z: 48, s: "Cd", n: "Cádmio", m: 112.41, g: 12, p: 5, c: "metal-transicao", en: 1.69, nox: "+2", cfg: "[Kr] 4d¹⁰ 5s²", st: "Sólido" },
    { z: 49, s: "In", n: "Índio", m: 114.82, g: 13, p: 5, c: "metal-pos-transicao", en: 1.78, nox: "+3", cfg: "[Kr] 4d¹⁰ 5s² 5p¹", st: "Sólido" },
    { z: 50, s: "Sn", n: "Estanho", m: 118.71, g: 14, p: 5, c: "metal-pos-transicao", en: 1.96, nox: "+4, +2", cfg: "[Kr] 4d¹⁰ 5s² 5p²", st: "Sólido" },
    { z: 51, s: "Sb", n: "Antimônio", m: 121.76, g: 15, p: 5, c: "semimetal", en: 2.05, nox: "+3, +5, -3", cfg: "[Kr] 4d¹⁰ 5s² 5p³", st: "Sólido" },
    { z: 52, s: "Te", n: "Telúrio", m: 127.60, g: 16, p: 5, c: "semimetal", en: 2.1, nox: "-2, +4, +6", cfg: "[Kr] 4d¹⁰ 5s² 5p⁴", st: "Sólido" },
    { z: 53, s: "I", n: "Iodo", m: 126.90, g: 17, p: 5, c: "halogenio", en: 2.66, nox: "-1, +1, +5, +7", cfg: "[Kr] 4d¹⁰ 5s² 5p⁵", st: "Sólido" },
    { z: 54, s: "Xe", n: "Xenônio", m: 131.29, g: 18, p: 5, c: "gas-nobre", en: 2.6, nox: "0, +2, +4, +6", cfg: "[Kr] 4d¹⁰ 5s² 5p⁶", st: "Gasoso" },

    { z: 55, s: "Cs", n: "Césio", m: 132.91, g: 1, p: 6, c: "metal-alcalino", en: 0.79, nox: "+1", cfg: "[Xe] 6s¹", st: "Sólido" },
    { z: 56, s: "Ba", n: "Bário", m: 137.33, g: 2, p: 6, c: "alcalino-terroso", en: 0.89, nox: "+2", cfg: "[Xe] 6s²", st: "Sólido" },
    { z: 57, s: "La", n: "Lantânio", m: 138.91, g: 3, p: 6, c: "lantanideo", en: 1.10, nox: "+3", cfg: "[Xe] 5d¹ 6s²", st: "Sólido" },
    { z: 58, s: "Ce", n: "Cério", m: 140.12, g: null, p: 6, c: "lantanideo", en: 1.12, nox: "+3, +4", cfg: "[Xe] 4f¹ 5d¹ 6s²", st: "Sólido" },
    { z: 59, s: "Pr", n: "Praseodímio", m: 140.91, g: null, p: 6, c: "lantanideo", en: 1.13, nox: "+3", cfg: "[Xe] 4f³ 6s²", st: "Sólido" },
    { z: 60, s: "Nd", n: "Neodímio", m: 144.24, g: null, p: 6, c: "lantanideo", en: 1.14, nox: "+3", cfg: "[Xe] 4f⁴ 6s²", st: "Sólido" },
    { z: 61, s: "Pm", n: "Promécio", m: 145, g: null, p: 6, c: "lantanideo", en: 1.13, nox: "+3", cfg: "[Xe] 4f⁵ 6s²", st: "Sólido" },
    { z: 62, s: "Sm", n: "Samário", m: 150.36, g: null, p: 6, c: "lantanideo", en: 1.17, nox: "+3, +2", cfg: "[Xe] 4f⁶ 6s²", st: "Sólido" },
    { z: 63, s: "Eu", n: "Európio", m: 151.96, g: null, p: 6, c: "lantanideo", en: 1.20, nox: "+3, +2", cfg: "[Xe] 4f⁷ 6s²", st: "Sólido" },
    { z: 64, s: "Gd", n: "Gadolínio", m: 157.25, g: null, p: 6, c: "lantanideo", en: 1.20, nox: "+3", cfg: "[Xe] 4f⁷ 5d¹ 6s²", st: "Sólido" },
    { z: 65, s: "Tb", n: "Térbio", m: 158.93, g: null, p: 6, c: "lantanideo", en: 1.20, nox: "+3, +4", cfg: "[Xe] 4f⁹ 6s²", st: "Sólido" },
    { z: 66, s: "Dy", n: "Disprósio", m: 162.50, g: null, p: 6, c: "lantanideo", en: 1.22, nox: "+3", cfg: "[Xe] 4f¹⁰ 6s²", st: "Sólido" },
    { z: 67, s: "Ho", n: "Hólmio", m: 164.93, g: null, p: 6, c: "lantanideo", en: 1.23, nox: "+3", cfg: "[Xe] 4f¹¹ 6s²", st: "Sólido" },
    { z: 68, s: "Er", n: "Érbio", m: 167.26, g: null, p: 6, c: "lantanideo", en: 1.24, nox: "+3", cfg: "[Xe] 4f¹² 6s²", st: "Sólido" },
    { z: 69, s: "Tm", n: "Túlio", m: 168.93, g: null, p: 6, c: "lantanideo", en: 1.25, nox: "+3", cfg: "[Xe] 4f¹³ 6s²", st: "Sólido" },
    { z: 70, s: "Yb", n: "Itérbio", m: 173.05, g: null, p: 6, c: "lantanideo", en: 1.10, nox: "+3, +2", cfg: "[Xe] 4f¹⁴ 6s²", st: "Sólido" },
    { z: 71, s: "Lu", n: "Lutécio", m: 174.97, g: null, p: 6, c: "lantanideo", en: 1.27, nox: "+3", cfg: "[Xe] 4f¹⁴ 5d¹ 6s²", st: "Sólido" },
    { z: 72, s: "Hf", n: "Háfnio", m: 178.49, g: 4, p: 6, c: "metal-transicao", en: 1.3, nox: "+4", cfg: "[Xe] 4f¹⁴ 5d² 6s²", st: "Sólido" },
    { z: 73, s: "Ta", n: "Tântalo", m: 180.95, g: 5, p: 6, c: "metal-transicao", en: 1.5, nox: "+5", cfg: "[Xe] 4f¹⁴ 5d³ 6s²", st: "Sólido" },
    { z: 74, s: "W", n: "Tungstênio", m: 183.84, g: 6, p: 6, c: "metal-transicao", en: 2.36, nox: "+6, +4", cfg: "[Xe] 4f¹⁴ 5d⁴ 6s²", st: "Sólido" },
    { z: 75, s: "Re", n: "Rênio", m: 186.21, g: 7, p: 6, c: "metal-transicao", en: 1.9, nox: "+7, +4", cfg: "[Xe] 4f¹⁴ 5d⁵ 6s²", st: "Sólido" },
    { z: 76, s: "Os", n: "Ósmio", m: 190.23, g: 8, p: 6, c: "metal-transicao", en: 2.2, nox: "+4, +8", cfg: "[Xe] 4f¹⁴ 5d⁶ 6s²", st: "Sólido" },
    { z: 77, s: "Ir", n: "Irídio", m: 192.22, g: 9, p: 6, c: "metal-transicao", en: 2.20, nox: "+4, +3", cfg: "[Xe] 4f¹⁴ 5d⁷ 6s²", st: "Sólido" },
    { z: 78, s: "Pt", n: "Platina", m: 195.08, g: 10, p: 6, c: "metal-transicao", en: 2.28, nox: "+2, +4", cfg: "[Xe] 4f¹⁴ 5d⁹ 6s¹", st: "Sólido" },
    { z: 79, s: "Au", n: "Ouro", m: 196.97, g: 11, p: 6, c: "metal-transicao", en: 2.54, nox: "+3, +1", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s¹", st: "Sólido" },
    { z: 80, s: "Hg", n: "Mercúrio", m: 200.59, g: 12, p: 6, c: "metal-transicao", en: 2.00, nox: "+2, +1", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s²", st: "Líquido" },
    { z: 81, s: "Tl", n: "Tálio", m: 204.38, g: 13, p: 6, c: "metal-pos-transicao", en: 1.62, nox: "+1, +3", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p¹", st: "Sólido" },
    { z: 82, s: "Pb", n: "Chumbo", m: 207.2, g: 14, p: 6, c: "metal-pos-transicao", en: 2.33, nox: "+2, +4", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p²", st: "Sólido" },
    { z: 83, s: "Bi", n: "Bismuto", m: 208.98, g: 15, p: 6, c: "metal-pos-transicao", en: 2.02, nox: "+3, +5", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p³", st: "Sólido" },
    { z: 84, s: "Po", n: "Polônio", m: 209, g: 16, p: 6, c: "semimetal", en: 2.0, nox: "+4, +2", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁴", st: "Sólido" },
    { z: 85, s: "At", n: "Astato", m: 210, g: 17, p: 6, c: "halogenio", en: 2.2, nox: "-1, +1", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁵", st: "Sólido" },
    { z: 86, s: "Rn", n: "Radônio", m: 222, g: 18, p: 6, c: "gas-nobre", en: null, nox: "0", cfg: "[Xe] 4f¹⁴ 5d¹⁰ 6s² 6p⁶", st: "Gasoso" },

    { z: 87, s: "Fr", n: "Frâncio", m: 223, g: 1, p: 7, c: "metal-alcalino", en: 0.7, nox: "+1", cfg: "[Rn] 7s¹", st: "Sólido" },
    { z: 88, s: "Ra", n: "Rádio", m: 226, g: 2, p: 7, c: "alcalino-terroso", en: 0.9, nox: "+2", cfg: "[Rn] 7s²", st: "Sólido" },
    { z: 89, s: "Ac", n: "Actínio", m: 227, g: 3, p: 7, c: "actinideo", en: 1.1, nox: "+3", cfg: "[Rn] 6d¹ 7s²", st: "Sólido" },
    { z: 90, s: "Th", n: "Tório", m: 232.04, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+4", cfg: "[Rn] 6d² 7s²", st: "Sólido" },
    { z: 91, s: "Pa", n: "Protactínio", m: 231.04, g: null, p: 7, c: "actinideo", en: 1.5, nox: "+5, +4", cfg: "[Rn] 5f² 6d¹ 7s²", st: "Sólido" },
    { z: 92, s: "U", n: "Urânio", m: 238.03, g: null, p: 7, c: "actinideo", en: 1.38, nox: "+6, +4, +3", cfg: "[Rn] 5f³ 6d¹ 7s²", st: "Sólido" },
    { z: 93, s: "Np", n: "Netúnio", m: 237, g: null, p: 7, c: "actinideo", en: 1.36, nox: "+5, +4, +3", cfg: "[Rn] 5f⁴ 6d¹ 7s²", st: "Sólido" },
    { z: 94, s: "Pu", n: "Plutônio", m: 244, g: null, p: 7, c: "actinideo", en: 1.28, nox: "+4, +6, +3", cfg: "[Rn] 5f⁶ 7s²", st: "Sólido" },
    { z: 95, s: "Am", n: "Amerício", m: 243, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3, +4", cfg: "[Rn] 5f⁷ 7s²", st: "Sólido" },
    { z: 96, s: "Cm", n: "Cúrio", m: 247, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3, +4", cfg: "[Rn] 5f⁷ 6d¹ 7s²", st: "Sólido" },
    { z: 97, s: "Bk", n: "Berquélio", m: 247, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3, +4", cfg: "[Rn] 5f⁹ 7s²", st: "Sólido" },
    { z: 98, s: "Cf", n: "Califórnio", m: 251, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3", cfg: "[Rn] 5f¹⁰ 7s²", st: "Sólido" },
    { z: 99, s: "Es", n: "Einstênio", m: 252, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3", cfg: "[Rn] 5f¹¹ 7s²", st: "Sólido" },
    { z: 100, s: "Fm", n: "Férmio", m: 257, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3", cfg: "[Rn] 5f¹² 7s²", st: "Sólido" },
    { z: 101, s: "Md", n: "Mendelévio", m: 258, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3, +2", cfg: "[Rn] 5f¹³ 7s²", st: "Sólido" },
    { z: 102, s: "No", n: "Nobélio", m: 259, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+2, +3", cfg: "[Rn] 5f¹⁴ 7s²", st: "Sólido" },
    { z: 103, s: "Lr", n: "Laurêncio", m: 266, g: null, p: 7, c: "actinideo", en: 1.3, nox: "+3", cfg: "[Rn] 5f¹⁴ 7s² 7p¹", st: "Sólido" },
    { z: 104, s: "Rf", n: "Rutherfórdio", m: 267, g: 4, p: 7, c: "metal-transicao", en: null, nox: "+4", cfg: "[Rn] 5f¹⁴ 6d² 7s²", st: "Desconhecido" },
    { z: 105, s: "Db", n: "Dúbnio", m: 268, g: 5, p: 7, c: "metal-transicao", en: null, nox: "+5", cfg: "[Rn] 5f¹⁴ 6d³ 7s²", st: "Desconhecido" },
    { z: 106, s: "Sg", n: "Seabórgio", m: 269, g: 6, p: 7, c: "metal-transicao", en: null, nox: "+6", cfg: "[Rn] 5f¹⁴ 6d⁴ 7s²", st: "Desconhecido" },
    { z: 107, s: "Bh", n: "Bóhrio", m: 270, g: 7, p: 7, c: "metal-transicao", en: null, nox: "+7", cfg: "[Rn] 5f¹⁴ 6d⁵ 7s²", st: "Desconhecido" },
    { z: 108, s: "Hs", n: "Hássio", m: 277, g: 8, p: 7, c: "metal-transicao", en: null, nox: "+8", cfg: "[Rn] 5f¹⁴ 6d⁶ 7s²", st: "Desconhecido" },
    { z: 109, s: "Mt", n: "Meitnério", m: 278, g: 9, p: 7, c: "metal-transicao", en: null, nox: "+3, +4", cfg: "[Rn] 5f¹⁴ 6d⁷ 7s²", st: "Desconhecido" },
    { z: 110, s: "Ds", n: "Darmstádio", m: 281, g: 10, p: 7, c: "metal-transicao", en: null, nox: "+2, +4", cfg: "[Rn] 5f¹⁴ 6d⁸ 7s²", st: "Desconhecido" },
    { z: 111, s: "Rg", n: "Roentgênio", m: 282, g: 11, p: 7, c: "metal-transicao", en: null, nox: "+3", cfg: "[Rn] 5f¹⁴ 6d⁹ 7s²", st: "Desconhecido" },
    { z: 112, s: "Cn", n: "Copernício", m: 285, g: 12, p: 7, c: "metal-transicao", en: null, nox: "+2", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s²", st: "Desconhecido" },
    { z: 113, s: "Nh", n: "Nipônio", m: 286, g: 13, p: 7, c: "metal-pos-transicao", en: null, nox: "+1, +3", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p¹", st: "Desconhecido" },
    { z: 114, s: "Fl", n: "Fleróvio", m: 289, g: 14, p: 7, c: "metal-pos-transicao", en: null, nox: "+2, +4", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p²", st: "Desconhecido" },
    { z: 115, s: "Mc", n: "Moscóvio", m: 290, g: 15, p: 7, c: "metal-pos-transicao", en: null, nox: "+1, +3", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p³", st: "Desconhecido" },
    { z: 116, s: "Lv", n: "Livermório", m: 293, g: 16, p: 7, c: "metal-pos-transicao", en: null, nox: "+2, +4", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁴", st: "Desconhecido" },
    { z: 117, s: "Ts", n: "Tenessino", m: 294, g: 17, p: 7, c: "halogenio", en: null, nox: "-1, +1, +3", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁵", st: "Desconhecido" },
    { z: 118, s: "Og", n: "Oganessônio", m: 294, g: 18, p: 7, c: "gas-nobre", en: null, nox: "0", cfg: "[Rn] 5f¹⁴ 6d¹⁰ 7s² 7p⁶", st: "Desconhecido" }
];

// Mapeamento de categorias e cores visuais
const CATEGORY_NAMES = {
    "nao-metal": "Não-metal",
    "gas-nobre": "Gás Nobre",
    "metal-alcalino": "Metal Alcalino",
    "alcalino-terroso": "Metal Alcalinoterroso",
    "semimetal": "Semimetal",
    "halogenio": "Halogênio",
    "metal-transicao": "Metal de Transição",
    "metal-pos-transicao": "Metal Pós-Transição",
    "lantanideo": "Lantanídeo",
    "actinideo": "Actinídeo"
};

const CATEGORY_COLORS = {
    "nao-metal": { bg: "bg-emerald-500/15 border-emerald-500/30 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-500/25", pill: "bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300" },
    "gas-nobre": { bg: "bg-purple-500/15 border-purple-500/30 text-purple-700 dark:text-purple-300 hover:bg-purple-500/25", pill: "bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300" },
    "metal-alcalino": { bg: "bg-rose-500/15 border-rose-500/30 text-rose-700 dark:text-rose-300 hover:bg-rose-500/25", pill: "bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300" },
    "alcalino-terroso": { bg: "bg-orange-500/15 border-orange-500/30 text-orange-700 dark:text-orange-300 hover:bg-orange-500/25", pill: "bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300" },
    "semimetal": { bg: "bg-teal-500/15 border-teal-500/30 text-teal-700 dark:text-teal-300 hover:bg-teal-500/25", pill: "bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300" },
    "halogenio": { bg: "bg-amber-500/15 border-amber-500/30 text-amber-700 dark:text-amber-300 hover:bg-amber-500/25", pill: "bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300" },
    "metal-transicao": { bg: "bg-blue-500/15 border-blue-500/30 text-blue-700 dark:text-blue-300 hover:bg-blue-500/25", pill: "bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300" },
    "metal-pos-transicao": { bg: "bg-indigo-500/15 border-indigo-500/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-500/25", pill: "bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300" },
    "lantanideo": { bg: "bg-cyan-500/15 border-cyan-500/30 text-cyan-700 dark:text-cyan-300 hover:bg-cyan-500/25", pill: "bg-cyan-100 text-cyan-800 dark:bg-cyan-900/50 dark:text-cyan-300" },
    "actinideo": { bg: "bg-pink-500/15 border-pink-500/30 text-pink-700 dark:text-pink-300 hover:bg-pink-500/25", pill: "bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300" }
};

/**
 * Busca elemento pelo símbolo ou número atômico
 */
function findElement(query) {
    if (typeof query === "number") {
        return ELEMENTS_DATA.find(e => e.z === query);
    }
    const clean = String(query).trim().toLowerCase();
    return ELEMENTS_DATA.find(e => 
        e.s.toLowerCase() === clean || 
        e.n.toLowerCase() === clean || 
        String(e.z) === clean
    );
}

/**
 * Abre o Modal com todos os dados do elemento químico
 */
function showElementDetails(elem) {
    if (!elem) return;
    
    const modal = document.getElementById("element-modal");
    if (!modal) return;

    const catStyle = CATEGORY_COLORS[elem.c] || { bg: "bg-slate-500", pill: "bg-slate-100 text-slate-800" };

    document.getElementById("elem-modal-symbol").innerText = elem.s;
    document.getElementById("elem-modal-atomic-number").innerText = elem.z;
    document.getElementById("elem-modal-mass").innerText = Number(elem.m).toFixed(3);
    document.getElementById("elem-modal-name").innerText = elem.n;
    
    const catElem = document.getElementById("elem-modal-category");
    catElem.innerText = CATEGORY_NAMES[elem.c] || elem.c;
    catElem.className = `inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold ${catStyle.pill}`;

    document.getElementById("elem-modal-group").innerText = elem.g ? elem.g : "F-Block";
    document.getElementById("elem-modal-period").innerText = elem.p;
    document.getElementById("elem-modal-electronegativity").innerText = elem.en ? elem.en : "Não definida";
    document.getElementById("elem-modal-state").innerText = elem.st;
    document.getElementById("elem-modal-config").innerText = elem.cfg;
    document.getElementById("elem-modal-nox").innerText = elem.nox;

    // Configura botões de ação
    const btnInsert = document.getElementById("elem-modal-btn-insert");
    btnInsert.onclick = () => {
        // Se estiver em modo SPA/demo, volta para a visão de cálculo
        const viewCalcBtn = document.querySelector('.nav-view-btn[data-view="view-calc"]');
        if (viewCalcBtn && typeof switchView === "function") {
            switchView("view-calc");
        }

        const inputFormula = document.getElementById("formula-input");
        if (inputFormula) {
            if (typeof insertTextAtCursor === "function") {
                insertTextAtCursor(inputFormula, elem.s);
            } else {
                inputFormula.value += elem.s;
                inputFormula.focus();
            }
            if (typeof showToast === "function") {
                showToast("info", "Elemento Adicionado", `Símbolo ${elem.s} inserido na caixa de cálculo!`);
            }
        }
        closeElementModal();
    };

    const btnCopy = document.getElementById("elem-modal-btn-copy");
    btnCopy.onclick = () => {
        navigator.clipboard.writeText(elem.s).then(() => {
            if (typeof showToast === "function") {
                showToast("success", "Copiado!", `Símbolo ${elem.s} copiado para a área de transferência.`);
            }
        });
    };

    // Abre o modal
    modal.classList.remove("hidden");
    setTimeout(() => {
        modal.classList.remove("opacity-0");
        const card = modal.querySelector(".max-w-lg");
        if (card) card.classList.remove("scale-95");
    }, 10);
}

function closeElementModal() {
    const modal = document.getElementById("element-modal");
    if (!modal) return;
    modal.classList.add("opacity-0");
    const card = modal.querySelector(".max-w-lg");
    if (card) card.classList.add("scale-95");
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 250);
}

// Configura fechamento do modal no clique externo e botão X
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("element-modal");
    const closeBtn = document.getElementById("elem-modal-close");
    if (closeBtn) closeBtn.onclick = closeElementModal;
    if (modal) {
        modal.onclick = (e) => {
            if (e.target === modal) closeElementModal();
        };
    }
});
