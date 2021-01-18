// add new option to question on add_question page
// check if user uploaded image and change label and span text
const addOption = document.querySelector('.add-option');

addOption.addEventListener('click', e => {
        e.preventDefault();
        let optionContainer = document.querySelector('.calculator-option');
        let optionCount = optionContainer.querySelectorAll('.edit-form__option').length + 1;   

        const optionDiv = document.createElement('div');
        optionDiv.classList.add('edit-form__option');
        optionDiv.innerHTML = `
                <h3>Option ${optionCount}</h3>
                <div>
                        <label for="name-${optionCount}">Answer</label>
                        <input type="text" name="${optionCount}name" id="name-${optionCount}" placeholder="Answer">
                </div>
                <div>
                        <label for="check-${optionCount}">Correct Answer</label>
                        <input type="checkbox" name="${optionCount}check" id="check-${optionCount}">
                </div>
        
        `
        optionContainer.appendChild(optionDiv);
})