<div class="row">
    <div class="col col-md-6">
        <div class="form-group">
            <div class="input-group date" id="date_start" data-target-input="nearest">
                {{ Form::text(
                    'date_start',
                    isset($kampung->date_start)
                        ? $kampung->date_start->format('d / m / Y')
                        : null,
                    [
                        'class' => $errors->has('date_start') ? 'form-control is-invalid' : 'form-control',
                        'data-target' => 'date_start'
                    ]
                ) }}
                <div class="input-group-append" data-target="#date_start" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-6">
        <div class="form-group">
            <div class="input-group date" id="date_end" data-target-input="nearest">
                {{ Form::text(
                    'date_end',
                    isset($kampung->date_end)
                        ? $kampung->date_end->format('d / m / Y')
                        : null,
                    [
                        'class' => $errors->has('date_end') ? 'form-control is-invalid' : 'form-control',
                        'data-target' => 'date_end'
                    ]
                ) }}
                <div class="input-group-append" data-target="#date_end" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>