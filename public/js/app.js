$(document).ready(function () {

    // i keeps track of section numbers
    let i = 0;

    // j keeps track of field numbers

    // each time you click button #add (Add a Section), JQuery dynamically adds a section to the #section div
    $('#addSection').unbind().on('click', function () {

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
            '<textarea class="form-control" type="text" name="section_description[]" placeholder="Description ' + i + '"></textarea>' +
            '</div><h3>Add fields to your section</h3>' +
            '<div id="fields">' +
            '</div><a class="btn btn-primary" id="addField">Add Field</a> ' +
            '</article>').appendTo(section);


        i++;

    });


    // when #removeSection is clicked, remove the whole article containing the section
    $('body').unbind().on('click', '#removeSection', function () {
        $(this).parent('article').remove();
    });


    // when #addField is clicked, add another field to the section
    $('body').unbind().on('click', '#addField', function () {
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
            '<select class="form-control" name="type[]" value="text">' +
            '<option type="radio" value="text">Single Line Text</option>' +
            '<option type="radio" value="textarea">Multi Line Text</option>' +
            '<option type="radio" value="number">Numeric</option>' +
            '<option type="radio" value="radio">Radio Button</option>' +
            '<option type="radio" value="checkbox">Checkboxes</option>' +
            '<option type="radio" value="slider">Slider</option>>' +
            '</div></article>').appendTo(fields_div);

    });


    // when #removeField is clicked, remove the whole article containing the field
    $('body').on('click', '#removeField', function () {
        $(this).parent('article').remove();
    });

});
