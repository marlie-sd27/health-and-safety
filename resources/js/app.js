require('./bootstrap');

$(document).ready(function () {

    $(function (){
        $('[data-toggle="popover"]').popover({
            container:'body'
        });
    });

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

        $(function (){
            $('[data-toggle="popover"]').popover({
                container:'body'
            });
        });

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
            '<label for="label[]"><span class="required">*</span>Label</label>' +
            '<input class="form-control" type="text" name="label[]" placeholder="Label" required/>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="help[]">Help Description (optional)</label>' +
            '<button type="button" class="help" data-container="body" data-toggle="popover" ' +
            'data-placement="right" data-content="A help description looks just like this! It\'ll be right beside the field and give your users more clarification as to what this field is."><b>?</b>' +
            '</button>' +
            '<input class="form-control" type="text" name="help[]" placeholder="Help Description"/>' +
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
            '<option value="time">Time</option>' +
            '<option value="file">File Upload</option>' +
            '</select></div>' +
            '<input type="hidden" name="field_id[]" value="' + j + '"/>' +
            '<div id="options" class="d-none">'+
            '<label for="options[]"><span class="required">*</span>Options (enter each option separated by a comma)</label>' +
            '<button type="button" class="help" data-container="body" data-toggle="popover" ' +
            'data-placement="right" data-content="For a slider, the options are the min and max values for the slider. Otherwise, it\'s the options for the input field"><b>?</b>' +
            '</button>' +
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


    // clear search form inputs
    $('body').on('click', '#clear', function() {

        $('input').each(function( ) {
            $(this)[0].value = "";
        });

        $('option').each(function() {
            $(this).eq(0)[0].selected = false;
        });

    })

    // send ajax request to toggle a form's live/retired state
    $('body').on('click', '#live-toggle', function(event) {

        const form_id = event.target.name;
        const live = event.target.checked;

        $.ajax({
                method: 'post',
                url: "toggle-live",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'form': form_id,
                    'live': live,
                },
                dataType: 'JSON'
        }).done( function(msg) {
            if(msg !== "success")
            {
                alert("Something went wrong. Please reload the page and try again.")
            }
        });

    });


});
