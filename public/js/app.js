$(document).ready(function () {

    // i keeps track of section numbers
    let i = 0;

    // j keeps track of field numbers

    // each time you click button #add (Add a Section), JQuery dynamically adds a section to the #section div
    $('#addSection').on('click', function() {

        let j = 0;

        let section = $('#sections');

        $('<article>' +
            '<a class="btn btn-secondary" id="removeSection">Remove Section</a>' +
            '<div class="form-group">' +
            '<label for="section_title">Title</label>' +
            '<input class="form-control" type="text" name="section_title[]" placeholder="Title ' + i + '" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="section_description">Description</label>' +
            '<textarea class="form-control" type="text" name="section_description[]" placeholder="Description ' + i + '"></textarea>' +
            '</div><h3>Add fields to your section</h3>' +
            '<div id="fields">' +
            '</div><a class="btn btn-primary" id="addField">Add Field</a> ' +
            '</article>').appendTo(section);

        i++;

        // when #removeSection is clicked, remove the whole article containing the section
        $('body').on('click', '#removeSection', function() {
            $(this).parent('article').remove();
        });

        // when #addField is clicked, add another field to the section
        $('body').on('click', '#addField', function() {
            let fields_div = $(this).prev();

            $('<article>' +
                '<a class="btn btn-secondary" id="removeField">Remove Field</a>' +
                '<div class="form-group">' +
                '<label for="type">Label</label>' +
                '<input class="form-control" type="text" name="label[]" placeholder="Label ' + j + '"/>' +
                '</div>' +
                '<div class="form-group">' +
                '<input type="checkbox" name="required[]" value="off" placeholder="Label"/>' +
                '<label for="required">Required?</label>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="type">Type of Input</label><br/>' +
                '<select class="form-control" name="type[]" placeholder="Choose an input type">' +
                '<option type="radio" value="text">Single Line Text</option>' +
                '<option type="radio" value="textarea">Multi Line Text</option>' +
                '<option type="radio" value="number">Numeric</option>' +
                '<option type="radio" value="radio">Radio Button</option>' +
                '<option type="radio" value="checkbox">Checkboxes</option>' +
                '<option type="radio" value="slider">Slider</option>>' +
                '</div></article>').appendTo(fields_div);

            j++;

            $('body').on('click', '#removeField', function() {
                $(this).parent('article').remove();
            });

        });

    });




});
