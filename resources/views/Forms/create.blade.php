@extends('../layout')

@section('content')
    <div class="container">

        <h1>Create a new Form</h1>
        <p>Here you can create new forms. Start with a title and description. If applicable, define a recurrence for how
            often
            the form must be completed and who must complete the form. Add sections to break up the form! You can always
            edit it
            again later</p>
        <div class="container">
            <form action="/forms" method="post">
                @csrf
                <div class="form-group">
                    <label for="form_title">Title</label>
                    <input class="form-control" type="text" name="form_title" placeholder="Title" required>
                </div>
                <div class="form-group">
                    <label for="form_description">Description</label>
                    <textarea class="form-control" type="text" name="form_description"
                              placeholder="Description"></textarea>
                </div>
                <section class="container">
                    <h2>Defining Recurrences</h2>
                    <p>This describes how often per time unit the form is required to be completed. For example, it can
                        be one
                        time
                        per month or six times per year. </p>
                    <p><small><b>Note that July and August will be excluded from the year unless you specify otherwise
                                in the box below</b>
                        </small></p>
                    <p><small><b>Note that if you do not specify a required recurrence, it will not be required to
                                complete by
                                any
                                employee, but will still be available to fill out and submit.</b></small></p>
                    <div class="form-group row">
                        <input class="form-control col-md-2" type="number" name="rec_quantity" placeholder="Ex. 1">
                        <p> time(s) per </p>

                        <input class="form-control col-md-2" type="number" name="rec_repeat" placeholder="Ex. 2">

                        <select class="form-control col-md-2" name="rec_time_unit"
                                placeholder="Choose a unit of time">
                            <option value="w">week(s)</option>
                            <option value="m">month(s)</option>
                            <option value="y">year(s)</option>
                        </select>


                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="full_year">
                        <label for="full_year">Include July and August in the year?</label>
                    </div>

                    <div class="form-group">
                        <label for="required_role">Who is required to submit this form?</label>
                        <select class="form-control" name="required_role">
                            <option value="all">All staff</option>
                            <option value="principals">Principals and Vice Principals</option>
                        </select>
                    </div>
                </section>

                <section class="container">
                    <h2>Adding Sections</h2>
                    <p>Use sections to group your form fields! </p>

                    <div id="sections">

                    </div>
                    <a class="btn btn-primary" id="addSection">Add a Section</a>
                </section>

                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-secondary" type="reset">Reset</button>

            </form>
        </div>
@endsection
