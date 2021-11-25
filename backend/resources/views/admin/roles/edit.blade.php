@extends('admin.layouts.app', ['title' => $panelTitle])

@section('content')
    
    <!-- Content Header (Page header) -->
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">                
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header"></div>
                        
                        {{ Form::open(array(
                                        'method'=> 'POST',
                                        'class' => '',
                                        'route' => ['admin.role.edit-submit', $id],
                                        'name'  => 'updateRoleForm',
                                        'id'    => 'updateRoleForm',
                                        'files' => true,
                                        'novalidate' => true)) }}

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">@lang('custom_admin.label_role_name')<span class="red_star">*</span></label>
                                    {{ Form::text('name', $details['name'], array(
                                                                'id' => 'name',
                                                                'placeholder' => '',
                                                                'class' => 'form-control text-sm',
                                                                'required' => 'required'
                                                                )) }}
                                </div>
                                
                            <!-- Permission section start -->
                                <div class="add-edit-permission-wrap">
                                    <div class="permission-title">
                                        <div>
                                            <div class="icheck-danger d-inline">
                                                <input type="checkbox" class="mainSelectDeselectAll" id="checkboxDanger1">
                                                <label for="checkboxDanger1">
                                                    <span class="all-select">@lang('custom_admin.label_select_deselect_all')</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            @if (count($routeCollection) > 0)
                                @php $h = 1; @endphp
                                @foreach ($routeCollection as $group => $groupRow)
                                    @php
                                    $mainLabel = $group;
                                    @endphp
                                    <div class="col-md-12 individual_section">
                                        <div class="permission-title">
                                            <h2>{{ ucwords($mainLabel) }}</h2>
                                            <div>
                                                <div class="icheck-info d-inline">
                                                    <input type="checkbox" class="select_deselect selectDeselectAll" data-parentRoute="{{ $group }}" id="checkboxSuccess{{$h}}">
                                                    <label for="checkboxSuccess{{$h}}">
                                                        <span>@lang('custom_admin.label_select_deselect_all')</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="permission-content section_class">
                                            <ul>
                                            @php $listOrIndex = 1; $individualCheckedCount = 0; @endphp
                                            @foreach($groupRow as $row)
                                                @php
                                                $groupClass = str_replace(' ','_',$group);

                                                $labelName = str_replace(['admin.','.','-',$group], ['',' ',' ',''], $row['path']);
                                                if (strpos(trim($labelName), 'index') !== false) {
                                                    $labelName = str_replace('index','List',$labelName);
                                                }
                                                
                                                $subClass = str_replace('.','_',$row['path']);

                                                $listIndexClass = '';
                                                if ($listOrIndex == 1) $listIndexClass = $group.'_list_index';

                                                if (in_array($row['role_page_id'], $existingPermission)) {
                                                    $individualCheckedCount++;
                                                }
                                                @endphp
                                                <li>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" name="role_page_ids[]" value="{{$row['role_page_id']}}" @if(in_array($row['role_page_id'], $existingPermission))checked @endif data-page="{{ $group }}" data-path="{{ $row['path'] }}" data-class="{{ $groupClass }}" data-listIndex="{{$listIndexClass}}" class="setPermission {{ $groupClass }} {{ $subClass }} selectDeselectAll" id="checkboxPrimary_{{$h}}_{{$listOrIndex}}">
                                                        <label for="checkboxPrimary_{{$h}}_{{$listOrIndex}}">
                                                            <span>{{ ucwords($labelName) }}</span>
                                                        </label>
                                                    </div>
                                                </li>
                                                @php
                                                if(count($groupRow) == $individualCheckedCount) {
                                                @endphp
                                                    <script>
                                                    $(document).ready(function(){
                                                        $('.{{$groupClass}}').parents('div.individual_section').find('input[type=checkbox]:eq(0)').prop('checked', true);
                                                    });
                                                    </script>
                                                @php
                                                }
                                                $listOrIndex++;
                                                @endphp
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @php $h++; @endphp
                                @endforeach
                            @endif
                                </div>
                            <!-- Permission section end -->
                                
                            </div>                            
                            <div class="card-footer">
                                <a href="{{ route('admin.role.list') }}" class="btn bg-gradient-secondary">
                                    <i class="icon fas fa-ban"></i> @lang('custom_admin.btn_cancel')
                                </a>
                                &nbsp;
                                <button type="submit" class="btn bg-gradient-success float-right">
                                    <i class="fas fa-save"></i> @lang('custom_admin.btn_update')
                                </button>
                            </div>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
@include('admin.roles.scripts')
@endpush