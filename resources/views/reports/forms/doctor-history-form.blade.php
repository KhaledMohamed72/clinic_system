<div class="card-body">
    <div class="row">
        @php $input = 'doctor' @endphp
        @if(auth()->user()->hasRole(['admin','recep']) && $clinicType == 1)
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Doctor</label>
                    <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                        <option selected="" disabled="">Select Doctor</option>
                        @foreach($doctor_rows as $doctor_row)
                            <option value="{{$doctor_row->user_id}}"
                                {{old($input) == $doctor_row->user_id? 'selected' : ''}}>{{$doctor_row->doctor_name}}</option>
                        @endforeach
                    </select>
                    @error($input)<span class="badge badge-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
        @else
            <input type="hidden" name="{{$input}}" value="{{$doctor_rows[0]->id}}">
        @endif
        @php $input = 'from' @endphp
        <div class="col-sm-4 form-group datepickerdiv">
            <label class="control-label">From</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" value="{{old('from')}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'to' @endphp
        <div class="col-sm-4 form-group datepickerdiv">
            <label class="control-label">To</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" value="{{old('to')}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group text-right">
                <div class="icheck-primary d-inline">
                    <input type="checkbox" name="sessions" value="1"
                           id="sessions-history">
                    <label for="sessions-history">
                        Sessions
                    </label>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group text-center">
                <div class="icheck-primary d-inline">
                    <input type="checkbox" name="incomes" value="1"
                           id="incomes-history">
                    <label for="incomes-history">
                        Incomes
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
