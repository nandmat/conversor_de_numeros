const buttonDecimalNumber = document.querySelector('#buttonDecimalNumber');
const buttonRomanNumeral = document.querySelector('#buttonRomanNumeral');
const divResult = document.querySelector('#result');
const spinner = document.querySelector('#spinner');


buttonDecimalNumber.addEventListener('click', function () {

    const decimalNumber = document.querySelector('#decimal_number');

    if (decimalNumber.value === '') {
        decimalNumber.classList.add('is-invalid');
        return;
    }

    if (decimalNumber.classList.contains('is-invalid')) {
        decimalNumber.classList.remove('is-invalid');
    }
    getResult(decimalNumber.value, 'decimal_to_roman');
});

buttonRomanNumeral.addEventListener('click', function () {
    const romanNumber = document.querySelector('#roman_numeral');

    if(romanNumber.value === ''){
        romanNumber.classList.add('is-invalid');
        return;
    }

    if(romanNumber.classList.contains('is-invalid')){
        romanNumber.classList.remove('is-invalid');
    }

    getResult(romanNumber.value, 'roman_to_decimal');

});

function getResult(argument, type) {

    spinner.classList.remove('d-none');
    divResult.innerHTML = '';

    fetch(`/api/get-result/${argument}/${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {

                spinner.classList.add('d-none');
                const error = data.error;
                const divError = document.createElement('div');
                divError.className = 'alert alert-danger';
                divError.innerText = error;

                divResult.appendChild(divError);
            } else {
                spinner.classList.add('d-none')
                const resultValue = data.result;

                if (resultValue !== '') {
                    const alertSuccess = document.createElement('div');
                    alertSuccess.className = 'alert alert-success';
                    alertSuccess.innerHTML = `Resultado: <b>${resultValue}</b>`;
                    divResult.appendChild(alertSuccess);
                    divResult.classList.remove('d-none');
                }
            }
        })
        .catch(error => {
            console.error('Erro ao buscar a conversão:', error);
            const divError = document.createElement('div');
            divError.className = 'alert alert-danger';
            divError.innerText = 'Erro interno, tente novamente!';
        });

}

