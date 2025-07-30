@extends('layouts.app')

@section('title', 'Edit Foreigner')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2"></i>
        Edit Foreigner: {{ $foreigner->first_name }} {{ $foreigner->last_name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('foreigners.show', $foreigner) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i>
                View Details
            </a>
            <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to List
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="POST" action="{{ route('foreigners.update', $foreigner) }}" id="foreignerForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name', $foreigner->first_name) }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name', $foreigner->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $foreigner->date_of_birth?->format('Y-m-d')) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $foreigner->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $foreigner->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $foreigner->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nationality') is-invalid @enderror" 
                                       id="nationality" name="nationality" value="{{ old('nationality', $foreigner->nationality) }}" required>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">e.g., American, British, French</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="passport_number" class="form-label">Passport Number</label>
                                <input type="text" class="form-control @error('passport_number') is-invalid @enderror" 
                                       id="passport_number" name="passport_number" value="{{ old('passport_number', $foreigner->passport_number) }}">
                                @error('passport_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="photo" class="form-label">
                                    <i class="fas fa-camera me-2"></i>
                                    Foto WNA
                                </label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                       id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($foreigner->photo)
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div class="card border">
                                        <img src="{{ asset('uploads/photos/' . $foreigner->photo) }}" 
                                             class="card-img-top" 
                                             alt="Photo of {{ $foreigner->full_name }}"
                                             style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted">{{ $foreigner->photo }}</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div class="card border text-center p-3">
                                        <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                                        <small class="text-muted">Belum ada foto</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visa Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-id-card me-2"></i>
                        Visa Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_type" class="form-label">Visa Type</label>
                                <select class="form-select @error('visa_type') is-invalid @enderror" id="visa_type" name="visa_type">
                                    <option value="">Select Visa Type</option>
                                    <option value="Tourist" {{ old('visa_type', $foreigner->visa_type) === 'Tourist' ? 'selected' : '' }}>Tourist</option>
                                    <option value="Business" {{ old('visa_type', $foreigner->visa_type) === 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Student" {{ old('visa_type', $foreigner->visa_type) === 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Work" {{ old('visa_type', $foreigner->visa_type) === 'Work' ? 'selected' : '' }}>Work</option>
                                    <option value="Transit" {{ old('visa_type', $foreigner->visa_type) === 'Transit' ? 'selected' : '' }}>Transit</option>
                                    <option value="Diplomatic" {{ old('visa_type', $foreigner->visa_type) === 'Diplomatic' ? 'selected' : '' }}>Diplomatic</option>
                                    <option value="Other" {{ old('visa_type', $foreigner->visa_type) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('visa_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_status" class="form-label">Visa Status</label>
                                <select class="form-select @error('visa_status') is-invalid @enderror" id="visa_status" name="visa_status">
                                    <option value="">Select Status</option>
                                    <option value="Active" {{ old('visa_status', $foreigner->visa_status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Expired" {{ old('visa_status', $foreigner->visa_status) === 'Expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="Pending" {{ old('visa_status', $foreigner->visa_status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Cancelled" {{ old('visa_status', $foreigner->visa_status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('visa_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entry_date" class="form-label">Entry Date</label>
                                <input type="date" class="form-control @error('entry_date') is-invalid @enderror" 
                                       id="entry_date" name="entry_date" 
                                       value="{{ old('entry_date', $foreigner->entry_date?->format('Y-m-d')) }}">
                                @error('entry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_expiry" class="form-label">Visa Expiry Date</label>
                                <input type="date" class="form-control @error('visa_expiry') is-invalid @enderror" 
                                       id="visa_expiry" name="visa_expiry" 
                                       value="{{ old('visa_expiry', $foreigner->visa_expiry?->format('Y-m-d')) }}">
                                @error('visa_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Location Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="current_address" class="form-label">Current Address *</label>
                        <textarea class="form-control @error('current_address') is-invalid @enderror" 
                                  id="current_address" name="current_address" rows="3" required>{{ old('current_address', $foreigner->current_address) }}</textarea>
                        @error('current_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="region_id" class="form-label">Region</label>
                        <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id">
                            <option value="">Select Region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id', $foreigner->region_id) == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" name="latitude" value="{{ old('latitude', $foreigner->latitude) }}">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Decimal degrees (e.g., 40.7128)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude', $foreigner->longitude) }}">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Decimal degrees (e.g., -74.0060)</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary" id="getLocationBtn">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Get Current Location
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-address-book me-2"></i>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $foreigner->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $foreigner->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <textarea class="form-control @error('emergency_contact') is-invalid @enderror" 
                                  id="emergency_contact" name="emergency_contact" rows="3" 
                                  placeholder="Name, relationship, phone number, and address">{{ old('emergency_contact', $foreigner->emergency_contact) }}</textarea>
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Form Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-save me-2"></i>
                        Save Changes
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Foreigner
                        </button>
                        <a href="{{ route('foreigners.show', $foreigner) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Current Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $foreigner->first_name }} {{ $foreigner->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Nationality:</th>
                            <td>{{ $foreigner->nationality }}</td>
                        </tr>
                        <tr>
                            <th>Visa Status:</th>
                            <td>
                                <span class="badge bg-{{ $foreigner->visa_status === 'Active' ? 'success' : ($foreigner->visa_status === 'Expired' ? 'danger' : 'warning') }}">
                                    {{ $foreigner->visa_status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td class="text-muted">{{ \App\Helpers\DateHelper::formatIndonesian($foreigner->updated_at, 'd F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get current location functionality
        const getLocationBtn = document.getElementById('getLocationBtn');
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        getLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                getLocationBtn.disabled = true;
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Getting Location...';
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        latInput.value = position.coords.latitude;
                        lngInput.value = position.coords.longitude;
                        
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-check me-2"></i>Location Retrieved';
                        getLocationBtn.classList.remove('btn-outline-secondary');
                        getLocationBtn.classList.add('btn-success');
                        
                        setTimeout(() => {
                            getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i>Get Current Location';
                            getLocationBtn.classList.remove('btn-success');
                            getLocationBtn.classList.add('btn-outline-secondary');
                        }, 2000);
                    },
                    function(error) {
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Location Failed';
                        getLocationBtn.classList.remove('btn-outline-secondary');
                        getLocationBtn.classList.add('btn-danger');
                        
                        console.error('Error getting location:', error);
                        alert('Unable to get your location. Please enter coordinates manually.');
                        
                        setTimeout(() => {
                            getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i>Get Current Location';
                            getLocationBtn.classList.remove('btn-danger');
                            getLocationBtn.classList.add('btn-outline-secondary');
                        }, 3000);
                    }
                );
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });

        // Form validation
        const form = document.getElementById('foreignerForm');
        const firstNameInput = document.getElementById('first_name');
        const lastNameInput = document.getElementById('last_name');
        const nationalityInput = document.getElementById('nationality');

        function validateRequired(input) {
            if (input.value.trim() === '') {
                input.classList.add('is-invalid');
                return false;
            } else {
                input.classList.remove('is-invalid');
                return true;
            }
        }

        [firstNameInput, lastNameInput, nationalityInput].forEach(input => {
            input.addEventListener('blur', () => validateRequired(input));
        });

        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            if (!validateRequired(firstNameInput)) isValid = false;
            if (!validateRequired(lastNameInput)) isValid = false;
            if (!validateRequired(nationalityInput)) isValid = false;
            
            if (!isValid) {
                e.preventDefault();
                document.querySelector('.is-invalid').focus();
            }
        });
    });
</script>
@endpush
