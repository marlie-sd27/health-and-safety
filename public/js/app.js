$(document).ready(function () {

    // i keeps track of section numbers
    let i = 0;


    // when #addSection is clicked, add a section to the #section div
    $('#addSection').on('click', function () {

        let section = $('#sections');

        $('<article class="container">' +
            '<input type="hidden" value="' + i + '" name="s_id[]" />' +
            '<p id="removeSection"><b>X</b></p>' +
            '<div class="form-group">' +
            '<label for="section_title">Title</label>' +
            '<input class="form-control" type="text" name="section_title[]" placeholder="Title" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="section_description">Description</label>' +
            '<textarea class="form-control" name="section_description[]" placeholder="Description"></textarea>' +
            '</div><h3>Add fields to your section</h3>' +
            '<div id="fields">' +
            '</div><button class="btn btn-info" id="addField" type="button">Add Field</button> ' +
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
            '<p id="removeField"><b>X</b></p>' +
            '<div class="form-group">' +
            '<label for="type">Label</label>' +
            '<input class="form-control" type="text" name="label[]" placeholder="Label"/>' +
            '</div>' +
            '<div class="form-group">' +
            '<input type="checkbox" name="required[]" placeholder="Label"/>' +
            '<label for="required">Required?</label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="type">Type of Input</label><br/>' +
            '<select class="form-control" name="type[]" id="type">' +
            '<option value="text">Single Line Text</option>' +
            '<option value="textarea">Multi Line Text</option>' +
            '<option value="select">Drop Down Menu</option>' +
            '<option value="number">Numeric</option>' +
            '<option value="radio">Radio Button</option>' +
            '<option value="checkbox">Checkboxes</option>' +
            '<option value="slider">Slider</option>' +
            '</select></div>' +
            '<div id="options" class="d-none">'+
            '<label for="options[]">Options (enter each option separated by a comma)</label>' +
            '<input type="text" name="options[]" class="form-control"/>' +
            '</div></article>').appendTo(fields_div);

        j++;

    });


    // when #removeField is clicked, remove the whole article containing the field
    $('body').on('click', '#removeField', function () {
        $(this).parent('article').remove();
    });


    // if type of input is drop down menu, radio buttons, checkbox or slider,
    $('body').on('change', "#type", function () {

        let parent = $(this).closest('article')
        let selected = $(this).children("option:selected").val();

        if (selected === "select" | selected === "checkbox" | selected === "radio" | selected === "slider") {
            parent.children("#options").removeClass("d-none");

        } else {
            parent.children("#options").addClass("d-none");

        }
    })

});
