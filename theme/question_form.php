<!-- form for creating new question and options -->
<div class="questionContainer">
    <div>
        <label for="question">Your question</label><br>
        <input type="text" name="question" id="question" placeholder="Question" value="<?php echo $errorMessage ? $_POST['question'] : ''; ?>">
    </div>
    <div class="calculator-option">
        <div class="edit-form__option">
            <h3>Option 1</h3>
            <div>
                <label for="name-1">Answer</label>
                <input type="text" name="1name" id="name-1" placeholder="Answer" value="<?php echo $errorMessage ? $_POST['1name'] : ''; ?>">
            </div>
            <div>
                <label for="check-1">Correct Answer</label>
                <input type="checkbox" name="1check" id="check-1">
            </div>
        </div>
        <div class="edit-form__option">
            <h3>Option 2</h3>
            <div>
                <label for="name-2">Answer</label>
                <input type="text" name="2name" id="name-2" placeholder="Answer" value="<?php echo $errorMessage ? $_POST['2name'] : ''; ?>">
            </div>
            <div>
                <label for="check-2">Correct Answer</label>
                <input type="checkbox" name="2check" id="check-2">
            </div>
        </div>
    </div>
    <div>
        <label for="exp">Explanation</label>
        <input type="text" name="exp" id="exp" placeholder="An explanation that will be displayed after the quiz is completed..." value="<?php echo $errorMessage ? $_POST['exp'] : ''; ?>">
    </div>
    <button class="add-option special">Add option</button>
</div>
