/**
 * @source Lista de DDD - <https://gist.github.com/ThadeuLuz/797b60972f74f3080b32642eb36481a5>
 * @source Gerar lista de CPF - <https://codepen.io/ogeradordecpf/pen/OaMvwq>
 * @source Gerar lista de nomes - <https://fossbytes.com/tools/random-name-generator>
 * @source Gerar email aleatório - <https://www.folkstalk.com/2022/07/generate-random-email-account-javascript-with-code-examples.html>
 * @source Gerador de CPF e CNPJ válidos - <https://codepen.io/WalterNascimento/pen/xxVRKgm?editors=1010>
 */
 var estadoPorDdd = {
    "11": "SP",
    "12": "SP",
    "13": "SP",
    "14": "SP",
    "15": "SP",
    "16": "SP",
    "17": "SP",
    "18": "SP",
    "19": "SP",
    "21": "RJ",
    "22": "RJ",
    "24": "RJ",
    "27": "ES",
    "28": "ES",
    "31": "MG",
    "32": "MG",
    "33": "MG",
    "34": "MG",
    "35": "MG",
    "37": "MG",
    "38": "MG",
    "41": "PR",
    "42": "PR",
    "43": "PR",
    "44": "PR",
    "45": "PR",
    "46": "PR",
    "47": "SC",
    "48": "SC",
    "49": "SC",
    "51": "RS",
    "53": "RS",
    "54": "RS",
    "55": "RS",
    "61": "DF",
    "62": "GO",
    "63": "TO",
    "64": "GO",
    "65": "MT",
    "66": "MT",
    "67": "MS",
    "68": "AC",
    "69": "RO",
    "71": "BA",
    "73": "BA",
    "74": "BA",
    "75": "BA",
    "77": "BA",
    "79": "SE",
    "81": "PE",
    "82": "AL",
    "83": "PB",
    "84": "RN",
    "85": "CE",
    "86": "PI",
    "87": "PE",
    "88": "CE",
    "89": "PI",
    "91": "PA",
    "92": "AM",
    "93": "PA",
    "94": "PA",
    "95": "RR",
    "96": "AP",
    "97": "AM",
    "98": "MA",
    "99": "MA"
};

var dddsPorEstado = {
    "AC": ["68"],
    "AL": ["82"],
    "AM": ["92", "97"],
    "AP": ["96"],
    "BA": ["71", "73", "74", "75", "77"],
    "CE": ["85", "88"],
    "DF": ["61"],
    "ES": ["27", "28"],
    "GO": ["62", "64"],
    "MA": ["98", "99"],
    "MG": ["31", "32", "33", "34", "35", "37", "38"],
    "MS": ["67"],
    "MT": ["65", "66"],
    "PA": ["91", "93", "94"],
    "PB": ["83"],
    "PE": ["81", "87"],
    "PI": ["86", "89"],
    "PR": ["41", "42", "43", "44", "45", "46"],
    "RJ": ["21", "22", "24"],
    "RN": ["84"],
    "RO": ["69"],
    "RR": ["95"],
    "RS": ["51", "53", "54", "55"],
    "SC": ["47", "48", "49"],
    "SE": ["79"],
    "SP": ["11", "12", "13", "14", "15", "16", "17", "18", "19"],
    "TO": ["63"]
}
var ddd = ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '24', '27', '28', '31', '32', '33', '34', '35', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48', '49', '51', '53', '54', '55', '61', '62', '63', '64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', '88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99'];
var pessoasArray = [
    "Dra. Nicole Azevedo",
    "Dra. Emanuella Costa",
    "Isabella Souza",
    "Elisa Barbosa",
    "Fernando Dias",
    "Gustavo Henrique Almeida",
    "Pedro Henrique Sales",
    "Bianca Nascimento",
    "Maria Clara Novaes",
    "Sabrina Viana",
    "Nathan Duarte",
    "Júlia Lopes",
    "Anthony Moreira",
    "Davi Mendes",
    "Miguel Costa",
    "Rafael Aragão",
    "Marcela Costa",
    "Luana Porto",
    "Matheus Vieira",
    "Dra. Maria Jesus",
    "Stella Melo",
    "Benjamin Ramos",
    "Bárbara Jesus",
    "Levi Caldeira",
    "Sabrina Porto",
    "João Ramos",
    "Rafaela Mendes",
    "Davi Lucca Sales",
    "Pedro Miguel da Conceição",
    "Rafael Caldeira",
    "Levi Lima",
    "Pietra da Conceição",
    "Eduarda Moraes",
    "Vitor Hugo Correia",
    "Vitor Gabriel Cavalcanti",
    "Manuela Novaes",
    "Mariana Rodrigues",
    "Francisco Cunha",
    "Kaique Farias",
    "Antônio Barbosa",
    "Dr. Luiz Gustavo Alves",
    "Marcela Lima",
    "Luiza Cavalcanti",
    "Diego Cunha",
    "Srta. Marcela Silva",
    "Paulo Pereira",
    "Srta. Alice Pinto",
    "Ana Júlia Moreira",
    "Carolina Porto",
    "Sr. Levi Peixoto",
    "Sr. Augusto Silva",
    "Sr. Davi Gonçalves",
    "Maitê Moura",
    "Ana Laura da Paz",
    "Maria Alice Melo",
    "Theo Ramos",
    "Carlos Eduardo Castro",
    "Lucca Farias",
    "Eduarda Moura",
    "Eduarda Fogaça",
    "Camila Nogueira",
    "Leandro Ramos",
    "Levi Gonçalves",
    "Thales Silveira",
    "Isabelly da Cunha",
    "Paulo Cardoso",
    "Julia Nascimento",
    "Felipe Moura",
    "Thomas Pereira",
    "Lucas Gabriel Teixeira",
    "Lorenzo da Costa",
    "Isabel Monteiro",
    "Cecília Fernandes",
    "Letícia Nogueira",
    "Rafael da Costa",
    "Yasmin Duarte",
    "Esther da Mota",
    "Vitor Hugo Santos",
    "Sra. Larissa Costela",
    "Bárbara da Luz",
    "Bárbara Porto",
    "Srta. Alana Costa",
    "Miguel Fernandes",
    "Maria Eduarda da Cruz",
    "Rafaela Aragão",
    "Srta. Laís da Mata",
    "Ana Julia Gomes",
    "Melissa Pinto",
    "Vitor Hugo da Rocha",
    "Alexia Viana",
    "Luiz Gustavo Almeida",
    "Srta. Valentina Sales",
    "Maria Fernanda Silveira",
    "Matheus Rezende",
    "Lorena Pires",
    "Sra. Bianca da Rocha",
    "Ana Vitória Carvalho",
    "Dr. Davi Lucas Almeida",
    "Lívia Porto",
    "Natália Santos"
];
var domainsArray = [
    "gmail.dev",
    "hotmail.dev",
    "faker.dev",
    "dansp.dev",
    "yahoo.dev"
];
var user_datas = {};
/**
 * Get Random from array
 * @param {Array} items - Object/Array list to random response
 * @return {String|mixed}
*/
var getRandom = (items)=>{
    return items[Math.floor(Math.random()*items.length)];
}
/**
 * Get random number between two numbers min and max
 * @param {Integer} min
 * @param {Integer} max
 * @return {Integer}
*/
var randomNumber = (min,max) => {
    return Math.floor((Math.random())*(max-min+1))+min;
}

/**
 * Get email by name
 * @param {String} pessoa - Nome da pessoa, ex: "Daniel dos Santos"
 * @return {String}
*/
var getEmailUser = (pessoa) =>{
    var user_dt = [];
    user_dt.push(pessoa.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().replaceAll(' ', '.').replaceAll('..', '.'));
    user_dt.push(getRandom(domainsArray));
    return user_dt.join('@');
};
/**
 * Get an random number telephone in brazil format mobile
 * @return {String}
*/
var getTelephone = () =>{
    var getDDD = getRandom(ddd);
    var prefixNumber = String(randomNumber(97000, 99999)).padStart(5, '0');
    var sufixNumber = String(randomNumber(0000, 9999)).padStart(4, '0');
    return `${getDDD}${prefixNumber}${sufixNumber}`;
}

var create_array = (total, numero) => Array.from(Array(total), () => number_random(numero));
var number_random = (number) => (Math.round(Math.random() * number));
var mod = (dividendo, divisor) => Math.round(dividendo - (Math.floor(dividendo / divisor) * divisor));

const cpf = () => {
  var total_array = 9;
  let n = 9;
  let [n1, n2, n3, n4, n5, n6, n7, n8, n9] = create_array(total_array, n);

  let d1 = n9 * 2 + n8 * 3 + n7 * 4 + n6 * 5 + n5 * 6 + n4 * 7 + n3 * 8 + n2 * 9 + n1 * 10;
  d1 = 11 - (mod(d1, 11));
  if (d1 >= 10) d1 = 0;

  let d2 = d1 * 2 + n9 * 3 + n8 * 4 + n7 * 5 + n6 * 6 + n5 * 7 + n4 * 8 + n3 * 9 + n2 * 10 + n1 * 11;
  d2 = 11 - (mod(d2, 11));
  if (d2 >= 10) d2 = 0;
    return `${n1}${n2}${n3}${n4}${n5}${n6}${n7}${n8}${n9}${d1}${d2}`;
}

const cnpj = () => {
  let total_array = 8;
  let n = 9;
  let [n1, n2, n3, n4, n5, n6, n7, n8] = create_array(total_array, n);
  let n9 = 0;
  let n10 = 0;
  let n11 = 0;
  let n12 = 1;

  let d1 = n12 * 2 + n11 * 3 + n10 * 4 + n9 * 5 + n8 * 6 + n7 * 7 + n6 * 8 + n5 * 9 + n4 * 2 + n3 * 3 + n2 * 4 + n1 * 5;
  d1 = 11 - (mod(d1, 11));
  if (d1 >= 10) d1 = 0;

  let d2 = d1 * 2 + n12 * 3 + n11 * 4 + n10 * 5 + n9 * 6 + n8 * 7 + n7 * 8 + n6 * 9 + n5 * 2 + n4 * 3 + n3 * 4 + n2 * 5 + n1 * 6;
  d2 = 11 - (mod(d2, 11));
  if (d2 >= 10) d2 = 0;

    return `${n1}${n2}${n3}${n4}${n5}${n6}${n7}${n8}${n9}${n10}${n11}${n12}${d1}${d2}`;
}


/**
 * Get Random user name
*/
const userTest = () => {
    var user_selected = getRandom(pessoasArray); // Array from names
    user_datas['name']      = user_selected;
    user_datas['document']  = cpf();
    user_datas['telephone'] = getTelephone();
    user_datas['email']     = getEmailUser(user_selected);

    console.log('DEV MODE: ', user_datas);
    for( chave in user_datas ){
        console.log(chave, user_datas[chave]);
        var isEl = document.querySelectorAll(`#${chave}`);
        if( isEl.length > 0 ){
            isEl[0].value = user_datas[chave];
        }
    }
}
// userTest();