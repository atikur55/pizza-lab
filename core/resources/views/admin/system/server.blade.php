@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table--light style--two">
                    <tbody>
                      <tr>
                          <td>@lang('PHP Version')</td>
                          <td>{{ $currentPHP }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Server Software')</td>
                          <td>{{ @$serverDetails['SERVER_SOFTWARE'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Server IP Address')</td>
                          <td>{{ @$serverDetails['SERVER_ADDR'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Server Protocol')</td>
                          <td>{{ @$serverDetails['SERVER_PROTOCOL'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('HTTP Host')</td>
                          <td>{{ @$serverDetails['HTTP_HOST'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Server Port')</td>
                          <td>{{ @$serverDetails['SERVER_PORT'] }}</td>
                      </tr>
                    </tbody>
                  </table><!-- table end -->
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
  td{
    font-size: 22px !important;
  }
  .table td {
      white-space: nowrap;
  }
</style>
@endpush
