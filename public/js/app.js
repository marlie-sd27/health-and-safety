$(document).ready(function () {

    // i keeps track of section numbers
    let i = 0;

    // j keeps track of field numbers

    // when #addSection is clicked, add a section to the #section div
    $('#addSection').on('click', function () {

        let section = $('#sections');

        $('<article>' +
            '<input type="hidden" value="' + i + '" name="id[]" />' +
            '<a class="btn btn-secondary" id="removeSection">Remove Section</a>' +
            '<div class="form-group">' +
            '<label for="section_title">Title</label>' +
            '<input class="form-control" type="text" name="section_title[]" placeholder="Title ' + i + '" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="section_description">Description</label>' +
            '<textarea class="form-control" name="section_description[]" placeholder="Description ' + i + '"></textarea>' +
            '</div><h3>Add fields to your section</h3>' +
            '<div id="fields">' +
            '</div><a class="btn btn-primary" id="addField">Add Field</a> ' +
            '</article>').appendTo(section);

        i++;

    });


    // when #removeSection is clicked, remove the whole article containing the section
    $('body').on('click', '#removeSection', function () {
        $(this).parent('article').remove();
    });


    // when #addField is clicked, add another field to the section
    $('body').on('click', '#addField', function () {
        let fields_div = $(this).prev();

        // get the ID of the section this field is in
        // the first sibling is the input who's value is the section's ID
        let section_id = $(this).siblings()[0].value;

        $('<article>' +
            '<input type="hidden" name="section_id[]" value="' + section_id + '" />' +
            '<a class="btn btn-secondary" id="removeField">Remove Field</a>' +
            '<div class="form-group">' +
            '<label for="type">Label</label>' +
            '<input class="form-control" type="text" name="label[]" placeholder="Label"/>' +
            '</div>' +
            '<div class="form-group">' +
            '<input type="checkbox" name="required[]" value="off" placeholder="Label"/>' +
            '<label for="required">Required?</label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="type">Type of Input</label><br/>' +
            '<select class="form-control" name="type[]">' +
            '<option value="text">Single Line Text</option>' +
            '<option value="textarea">Multi Line Text</option>' +
            '<option value="number">Numeric</option>' +
            '<option value="radio">Radio Button</option>' +
            '<option value="checkbox">Checkboxes</option>' +
            '<option value="slider">Slider</option>>' +
            '</div></article>').appendTo(fields_div);

    });


    // when #removeField is clicked, remove the whole article containing the field
    $('body').on('click', '#removeField', function () {
        $(this).parent('article').remove();
    });

});
