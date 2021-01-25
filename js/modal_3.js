// modal for calculators, confirms that user wants to delete the calculator

var thequestions = document.querySelectorAll('.edit-form__question-container');

for(var question of thequestions) {
    question.addEventListener('click', e => {
        if(e.target.classList.contains('delete-question')) {
            let modal = question.querySelector('.modal-overlay');
            modal.classList.add('active');
        }
    });
}

const cancels = document.querySelectorAll('.cancel');

for(let cancel of cancels) {
    cancel.addEventListener('click', () => {
        cancel.parentElement.parentElement.parentElement.classList.remove('active');
    })
}