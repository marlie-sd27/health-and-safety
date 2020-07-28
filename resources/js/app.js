require('./bootstrap');

$(document).ready(function () {

    // i keeps track of section numbers
    let i = parseInt($("input[name='s_id[]']").last().val()) + 1;
    if ( isNaN(i)) {
        i = 0;
    }

    // j keeps track of field numbers
    let j = parseInt($("input[name='field_id[]']").last().val()) + 1;
    if ( isNaN(j)) {
        j = 0;
    }

    // when #addSection is clicked, add a section to the #section div
    $('#addSection').on('click', function () {

        let section = $('#sections');

        $('<article>' +
            '<img id="removeSection" src="/images/delete.png" height="25em;" alt="remove"/>' +
            '<div class="toggle-expand"></div>' +
            '<div class="container">' +
            '<input type="hidden" value="' + i + '" name="s_id[]" />' +
            '<div class="form-group">' +
            '<label for="section_title">Title</label>' +
            '<input class="form-control" type="text" name="section_title[]" placeholder="Title">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="section_description">Description</label>' +
            '<textarea class="form-control" name="section_description[]" placeholder="Description"></textarea>' +
            '</div><h3>Add fields to your section</h3>' +
            '<div id="fields">' +
            '</div><button class="btn btn-info" id="addField" type="button">Add Field</button> ' +
            '</div></article>').appendTo(section);

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
            '<img id="removeField" src="/images/delete.png" height="25em;" alt="remove"/>' +
            '<div class="toggle-expand"></div>' +
            '<div class="container">' +
            '<input type="hidden" name="section_id[]" value="' + section_id + '" />' +
            '<div class="form-group">' +
            '<label for="label[]">Label</label>' +
            '<input class="form-control" type="text" name="label[]" placeholder="Label" required/>' +
            '</div>' +
            '<div class="form-group">' +
            '<input type="checkbox" name="required[' + j + ']"/>' +
            '<label for="required">Required?</label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="type">Type of Input</label><br/>' +
            '<select class="form-control" name="type[]" id="type">' +
            '<option value="text">Single Line Text</option>' +
            '<option value="textarea">Multi Line Text</option>' +
            '<option value="select">Drop Down Menu</option>' +
            '<option value="number">Number</option>' +
            '<option value="radio">Radio Button</option>' +
            '<option value="checkbox">Checkboxes</option>' +
            '<option value="slider">Slider</option>' +
            '<option value="date">Date</option>' +
            '\'<option value="time">Time</option>' +
            '</select></div>' +
            '<input type="hidden" name="field_id[]" value="' + j + '"/>' +
            '<div id="options" class="d-none">'+
            '<label for="options[]">Options (enter each option separated by a comma)</label>' +
            '<input type="text" name="options[]" class="form-control"/>' +
            '</div></div></article>').appendTo(fields_div);

        j++;
    });


    // when #removeField is clicked, remove the whole article containing the field
    $('body').on('click', '#removeField', function () {
        $(this).parent('article').remove();
    });


    // if type of input is drop down menu, radio buttons, checkbox or slider, display, show the options input
    $('body').on('change', "#type", function () {

        let parent = $(this).closest('article')
        let selected = $(this).children("option:selected").val();

        if (selected === "select" | selected === "checkbox" | selected === "radio" | selected === "slider") {
            parent.find("#options").removeClass("d-none");

        } else {
            parent.find("#options").addClass("d-none");
        }
    });


    // toggle collapse/expand section and fields when icon is clicked
    $('body').on('click', '.toggle-collapse', function() {

        let target = $(this).next();
        target.toggleClass("d-none");
        $(this).toggleClass("toggle-collapse");
        $(this).toggleClass("toggle-expand");
    });

    $('body').on('click', '.toggle-expand', function() {

        let target = $(this).next();
        target.toggleClass("d-none");
        $(this).toggleClass("toggle-collapse");
        $(this).toggleClass("toggle-expand");
    });


    // display slider's value
    $('body').on('change', '#slider', function () {

        let value = $(this)[0].value;
        let target = $(this).parent().find("#slider_value");

        target.html(value);
    })


    $('body').on('keyup', '#searchUser', function() {
        console.log('triggered');
        // Declare variables
        var input, filter, tr, td, i, txtValue;
        input = document.getElementById("searchUser");
        filter = input.value.toUpperCase();
        tr = document.getElementsByClassName('row-data');
        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {

            td = tr[i].getElementsByTagName("td")[2];
            txtValue = td.innerHTML;
            console.log(txtValue);
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr.get(i).addClass("d-none");
            } else {
                tr.get(i).removeClass("d-none");
            }
        }
    });

    // $('.date').datepicker({
    //     multidate: true,
    //     format: 'dd-mm-yyyy'
    // });
});
