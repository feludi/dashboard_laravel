@extends('layouts.app')

@section('title', 'Import Foreign Nationals - Foreign Nationals Mapping System')
@section('page-title', 'Import Foreign Nationals')

@section('page-actions')
<a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i>Back to List
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Import Instructions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Import Instructions
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>How to Import:</h6>
                    <ol class="mb-0">
                        <li>Download the Excel template below</li>
                        <li>Fill in your foreign nationals data using the template</li>
                        <li>Save the file and upload it using the form below</li>
                        <li>Review the import results</li>
                    </ol>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Required Fields:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>First Name</li>
                            <li><i class="fas fa-check text-success me-2"></i>Last Name</li>
                            <li><i class="fas fa-check text-success me-2"></i>Date of Birth</li>
                            <li><i class="fas fa-check text-success me-2"></i>Gender (male/female/other)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Nationality (full name for flag display)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Passport Number (must be unique)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Residence Permit Type</li>
                            <li><i class="fas fa-check text-success me-2"></i>City/Regency (Kota/Kabupaten)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Required Fields (continued):</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Subdistrict (Kecamatan)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Village/Kelurahan</li>
                            <li><i class="fas fa-check text-success me-2"></i>Current Address</li>
                            <li><i class="fas fa-check text-success me-2"></i>Postal Code</li>
                            <li><i class="fas fa-check text-success me-2"></i>Country</li>
                            <li><i class="fas fa-check text-success me-2"></i>Residence Permit Expiry Date</li>
                        </ul>
                        <h6>Optional Fields:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-circle text-muted me-2"></i>Status (defaults to "active")</li>
                            <li><i class="fas fa-circle text-muted me-2"></i>Email</li>
                        </ul>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-flag me-2"></i>Important Notes:</h6>
                    <ul class="mb-0">
                        <li><strong>Nationality:</strong> Use full names (e.g., "American", "British", "Chinese") not abbreviations (USA, UK, CN) for proper flag display</li>
                        <li><strong>City/Regency:</strong> Use exact format: "Kota Cirebon", "Kabupaten Cirebon", "Kabupaten Indramayu", etc.</li>
                        <li><strong>Administrative Levels:</strong> Subdistrict = Kecamatan, Village = Kelurahan/Desa</li>
                        <li><strong>Date Format:</strong> Use YYYY-MM-DD format (e.g., 1990-05-15)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Download Template -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>Download Template
                </h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Download the Excel template with sample data and correct formatting.</p>
                <a href="{{ route('import.template') }}" class="btn btn-primary">
                    <i class="fas fa-file-excel me-2"></i>Download Excel Template
                </a>
            </div>
        </div>

        <!-- Import Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-upload me-2"></i>Upload Excel File
                </h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        
                        @if(session('import_errors') && count(session('import_errors')) > 0)
                            <div class="mt-3">
                                <button class="btn btn-sm btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#importErrors">
                                    <i class="fas fa-exclamation-triangle me-1"></i>View Errors ({{ count(session('import_errors')) }})
                                </button>
                                <div class="collapse mt-2" id="importErrors">
                                    <div class="alert alert-warning">
                                        <h6>Import Errors:</h6>
                                        <ul class="mb-0">
                                            @foreach(session('import_errors') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('import.foreigners') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Choose Excel File</label>
                        <input type="file" 
                               class="form-control @error('excel_file') is-invalid @enderror" 
                               id="excel_file" 
                               name="excel_file" 
                               accept=".xlsx,.xls,.csv"
                               required>
                        @error('excel_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Supported formats: Excel (.xlsx, .xls) and CSV files. Maximum size: 10MB.
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Duplicate passport numbers will be skipped. Make sure your Excel file follows the template format exactly.
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-2"></i>Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('excel_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        if (fileSize > 10) {
            alert('File size must be less than 10MB');
            e.target.value = '';
        }
    }
});
</script>
@endpush
