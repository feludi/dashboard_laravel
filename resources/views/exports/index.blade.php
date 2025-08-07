@extends('layouts.app')

@section('title', 'Data Export - ImmiTrace Immigration Office')
@section('page-title', 'Data Export')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-download me-2"></i>Export Foreigners Data
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('export.foreigners') }}" method="POST" class="export-form">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="format" class="form-label">Export Format</label>
                            <select name="format" id="format" class="form-select" required>
                                <option value="csv">CSV (Comma Separated Values)</option>
                                <option value="json">JSON (JavaScript Object Notation)</option>
                                <option value="excel">Excel (XLSX)</option>
                            </select>
                            <div class="form-text">Choose the format for your exported file</div>
                        </div>
                    </div>

                    <h6 class="mb-3">Filters (Optional)</h6>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="departed">Departed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <select name="nationality" id="nationality" class="form-select">
                                <option value="">All Nationalities</option>
                                @foreach(\App\Models\Foreigner::distinct('nationality')->pluck('nationality')->sort() as $nationality)
                                    <option value="{{ $nationality }}">{{ $nationality }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="residence_permit_type" class="form-label">Residence Permit Type</label>
                            <select name="residence_permit_type" id="residence_permit_type" class="form-select">
                                <option value="">All Residence Permit Types</option>
                                @foreach(\App\Models\Foreigner::distinct('residence_permit_type')->pluck('residence_permit_type')->sort() as $permitType)
                                    <option value="{{ $permitType }}">{{ $permitType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">City</label>
                            <select name="city" id="city" class="form-select">
                                <option value="">All Cities</option>
                                @foreach(\App\Models\Foreigner::distinct('city')->pluck('city')->sort() as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>Reset Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Export Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid">
                    <a href="{{ route('export.statistics') }}" class="btn btn-outline-success">
                        <i class="fas fa-chart-bar me-2"></i>Export Statistics Report
                    </a>
                </div>
                <div class="form-text mt-2">
                    Exports aggregated data including nationality distribution, residence permit types, and regional statistics.
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-info-circle me-2"></i>Export Information
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>CSV:</strong> Best for spreadsheet applications
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>JSON:</strong> Best for API integration
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Excel:</strong> Best for advanced analysis
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-shield-alt text-info me-2"></i>
                        All exports include timestamp and source information
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-filter text-warning me-2"></i>
                        Use filters to export specific subsets of data
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.querySelector('.export-form').reset();
}
</script>
@endsection
