@extends('layouts.app')

@section('title', 'Create Foreign National')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mt-4">
                <i class="fas fa-user-plus me-3"></i>Create Foreign National
            </h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('foreigners.index') }}">Foreign Nationals</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Overview -->
    <div class="alert alert-info mb-4">
        <div class="row">
            <div class="col-md-2 text-center">
                <i class="fas fa-user fa-2x text-primary mb-2"></i>
                <div><strong>Personal Info</strong></div>
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-passport fa-2x text-success mb-2"></i>
                <div><strong>Residence Permit Details</strong></div>
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-map-marker-alt fa-2x text-info mb-2"></i>
                <div><strong>Address</strong></div>
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-globe fa-2x text-warning mb-2"></i>
                <div><strong>Location</strong></div>
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-phone fa-2x text-secondary mb-2"></i>
                <div><strong>Contact</strong></div>
            </div>
            <div class="col-md-2 text-center">
                <i class="fas fa-save fa-2x text-dark mb-2"></i>
                <div><strong>Submit</strong></div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Please correct the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('foreigners.store') }}">
        @csrf

        <!-- Section 1: Personal Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border-primary">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <strong>Personal Details:</strong> Please enter the foreign national's basic personal information.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label fw-bold">
                                <i class="fas fa-user me-1 text-primary"></i>First Name *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" required
                                   placeholder="Enter first name">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label fw-bold">
                                <i class="fas fa-user me-1 text-primary"></i>Last Name *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                   placeholder="Enter last name">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label fw-bold">
                                <i class="fas fa-calendar me-1 text-primary"></i>Date of Birth *
                            </label>
                            <input type="date" class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-bold">
                                <i class="fas fa-venus-mars me-1 text-primary"></i>Gender *
                            </label>
                            <select class="form-select form-select-lg @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="nationality" class="form-label fw-bold">
                                <i class="fas fa-flag me-1 text-primary"></i>Nationality *
                            </label>
                            <select class="form-select form-select-lg @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                                <option value="">Select Nationality</option>
                                <option value="Afghan" {{ old('nationality') == 'Afghan' ? 'selected' : '' }}>Afghan</option>
                                <option value="Albanian" {{ old('nationality') == 'Albanian' ? 'selected' : '' }}>Albanian</option>
                                <option value="Algerian" {{ old('nationality') == 'Algerian' ? 'selected' : '' }}>Algerian</option>
                                <option value="American" {{ old('nationality') == 'American' ? 'selected' : '' }}>American</option>
                                <option value="Andorran" {{ old('nationality') == 'Andorran' ? 'selected' : '' }}>Andorran</option>
                                <option value="Angolan" {{ old('nationality') == 'Angolan' ? 'selected' : '' }}>Angolan</option>
                                <option value="Antiguans" {{ old('nationality') == 'Antiguans' ? 'selected' : '' }}>Antiguans</option>
                                <option value="Argentinean" {{ old('nationality') == 'Argentinean' ? 'selected' : '' }}>Argentinean</option>
                                <option value="Armenian" {{ old('nationality') == 'Armenian' ? 'selected' : '' }}>Armenian</option>
                                <option value="Australian" {{ old('nationality') == 'Australian' ? 'selected' : '' }}>Australian</option>
                                <option value="Austrian" {{ old('nationality') == 'Austrian' ? 'selected' : '' }}>Austrian</option>
                                <option value="Azerbaijani" {{ old('nationality') == 'Azerbaijani' ? 'selected' : '' }}>Azerbaijani</option>
                                <option value="Bahamian" {{ old('nationality') == 'Bahamian' ? 'selected' : '' }}>Bahamian</option>
                                <option value="Bahraini" {{ old('nationality') == 'Bahraini' ? 'selected' : '' }}>Bahraini</option>
                                <option value="Bangladeshi" {{ old('nationality') == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                                <option value="Barbadian" {{ old('nationality') == 'Barbadian' ? 'selected' : '' }}>Barbadian</option>
                                <option value="Barbudans" {{ old('nationality') == 'Barbudans' ? 'selected' : '' }}>Barbudans</option>
                                <option value="Batswana" {{ old('nationality') == 'Batswana' ? 'selected' : '' }}>Batswana</option>
                                <option value="Belarusian" {{ old('nationality') == 'Belarusian' ? 'selected' : '' }}>Belarusian</option>
                                <option value="Belgian" {{ old('nationality') == 'Belgian' ? 'selected' : '' }}>Belgian</option>
                                <option value="Belizean" {{ old('nationality') == 'Belizean' ? 'selected' : '' }}>Belizean</option>
                                <option value="Beninese" {{ old('nationality') == 'Beninese' ? 'selected' : '' }}>Beninese</option>
                                <option value="Bhutanese" {{ old('nationality') == 'Bhutanese' ? 'selected' : '' }}>Bhutanese</option>
                                <option value="Bolivian" {{ old('nationality') == 'Bolivian' ? 'selected' : '' }}>Bolivian</option>
                                <option value="Bosnian" {{ old('nationality') == 'Bosnian' ? 'selected' : '' }}>Bosnian</option>
                                <option value="Brazilian" {{ old('nationality') == 'Brazilian' ? 'selected' : '' }}>Brazilian</option>
                                <option value="British" {{ old('nationality') == 'British' ? 'selected' : '' }}>British</option>
                                <option value="Bruneian" {{ old('nationality') == 'Bruneian' ? 'selected' : '' }}>Bruneian</option>
                                <option value="Bulgarian" {{ old('nationality') == 'Bulgarian' ? 'selected' : '' }}>Bulgarian</option>
                                <option value="Burkinabe" {{ old('nationality') == 'Burkinabe' ? 'selected' : '' }}>Burkinabe</option>
                                <option value="Burmese" {{ old('nationality') == 'Burmese' ? 'selected' : '' }}>Burmese</option>
                                <option value="Burundian" {{ old('nationality') == 'Burundian' ? 'selected' : '' }}>Burundian</option>
                                <option value="Cambodian" {{ old('nationality') == 'Cambodian' ? 'selected' : '' }}>Cambodian</option>
                                <option value="Cameroonian" {{ old('nationality') == 'Cameroonian' ? 'selected' : '' }}>Cameroonian</option>
                                <option value="Canadian" {{ old('nationality') == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                <option value="Cape Verdean" {{ old('nationality') == 'Cape Verdean' ? 'selected' : '' }}>Cape Verdean</option>
                                <option value="Central African" {{ old('nationality') == 'Central African' ? 'selected' : '' }}>Central African</option>
                                <option value="Chadian" {{ old('nationality') == 'Chadian' ? 'selected' : '' }}>Chadian</option>
                                <option value="Chilean" {{ old('nationality') == 'Chilean' ? 'selected' : '' }}>Chilean</option>
                                <option value="Chinese" {{ old('nationality') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                <option value="Colombian" {{ old('nationality') == 'Colombian' ? 'selected' : '' }}>Colombian</option>
                                <option value="Comoran" {{ old('nationality') == 'Comoran' ? 'selected' : '' }}>Comoran</option>
                                <option value="Congolese" {{ old('nationality') == 'Congolese' ? 'selected' : '' }}>Congolese</option>
                                <option value="Costa Rican" {{ old('nationality') == 'Costa Rican' ? 'selected' : '' }}>Costa Rican</option>
                                <option value="Croatian" {{ old('nationality') == 'Croatian' ? 'selected' : '' }}>Croatian</option>
                                <option value="Cuban" {{ old('nationality') == 'Cuban' ? 'selected' : '' }}>Cuban</option>
                                <option value="Cypriot" {{ old('nationality') == 'Cypriot' ? 'selected' : '' }}>Cypriot</option>
                                <option value="Czech" {{ old('nationality') == 'Czech' ? 'selected' : '' }}>Czech</option>
                                <option value="Danish" {{ old('nationality') == 'Danish' ? 'selected' : '' }}>Danish</option>
                                <option value="Djibouti" {{ old('nationality') == 'Djibouti' ? 'selected' : '' }}>Djibouti</option>
                                <option value="Dominican" {{ old('nationality') == 'Dominican' ? 'selected' : '' }}>Dominican</option>
                                <option value="Dutch" {{ old('nationality') == 'Dutch' ? 'selected' : '' }}>Dutch</option>
                                <option value="Ecuadorean" {{ old('nationality') == 'Ecuadorean' ? 'selected' : '' }}>Ecuadorean</option>
                                <option value="Egyptian" {{ old('nationality') == 'Egyptian' ? 'selected' : '' }}>Egyptian</option>
                                <option value="Emirian" {{ old('nationality') == 'Emirian' ? 'selected' : '' }}>Emirian</option>
                                <option value="Equatorial Guinean" {{ old('nationality') == 'Equatorial Guinean' ? 'selected' : '' }}>Equatorial Guinean</option>
                                <option value="Eritrean" {{ old('nationality') == 'Eritrean' ? 'selected' : '' }}>Eritrean</option>
                                <option value="Estonian" {{ old('nationality') == 'Estonian' ? 'selected' : '' }}>Estonian</option>
                                <option value="Ethiopian" {{ old('nationality') == 'Ethiopian' ? 'selected' : '' }}>Ethiopian</option>
                                <option value="Fijian" {{ old('nationality') == 'Fijian' ? 'selected' : '' }}>Fijian</option>
                                <option value="Filipino" {{ old('nationality') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                <option value="Finnish" {{ old('nationality') == 'Finnish' ? 'selected' : '' }}>Finnish</option>
                                <option value="French" {{ old('nationality') == 'French' ? 'selected' : '' }}>French</option>
                                <option value="Gabonese" {{ old('nationality') == 'Gabonese' ? 'selected' : '' }}>Gabonese</option>
                                <option value="Gambian" {{ old('nationality') == 'Gambian' ? 'selected' : '' }}>Gambian</option>
                                <option value="Georgian" {{ old('nationality') == 'Georgian' ? 'selected' : '' }}>Georgian</option>
                                <option value="German" {{ old('nationality') == 'German' ? 'selected' : '' }}>German</option>
                                <option value="Ghanaian" {{ old('nationality') == 'Ghanaian' ? 'selected' : '' }}>Ghanaian</option>
                                <option value="Greek" {{ old('nationality') == 'Greek' ? 'selected' : '' }}>Greek</option>
                                <option value="Grenadian" {{ old('nationality') == 'Grenadian' ? 'selected' : '' }}>Grenadian</option>
                                <option value="Guatemalan" {{ old('nationality') == 'Guatemalan' ? 'selected' : '' }}>Guatemalan</option>
                                <option value="Guinea-Bissauan" {{ old('nationality') == 'Guinea-Bissauan' ? 'selected' : '' }}>Guinea-Bissauan</option>
                                <option value="Guinean" {{ old('nationality') == 'Guinean' ? 'selected' : '' }}>Guinean</option>
                                <option value="Guyanese" {{ old('nationality') == 'Guyanese' ? 'selected' : '' }}>Guyanese</option>
                                <option value="Haitian" {{ old('nationality') == 'Haitian' ? 'selected' : '' }}>Haitian</option>
                                <option value="Herzegovinian" {{ old('nationality') == 'Herzegovinian' ? 'selected' : '' }}>Herzegovinian</option>
                                <option value="Honduran" {{ old('nationality') == 'Honduran' ? 'selected' : '' }}>Honduran</option>
                                <option value="Hungarian" {{ old('nationality') == 'Hungarian' ? 'selected' : '' }}>Hungarian</option>
                                <option value="Icelander" {{ old('nationality') == 'Icelander' ? 'selected' : '' }}>Icelander</option>
                                <option value="Indian" {{ old('nationality') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                <option value="Indonesian" {{ old('nationality') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                <option value="Iranian" {{ old('nationality') == 'Iranian' ? 'selected' : '' }}>Iranian</option>
                                <option value="Iraqi" {{ old('nationality') == 'Iraqi' ? 'selected' : '' }}>Iraqi</option>
                                <option value="Irish" {{ old('nationality') == 'Irish' ? 'selected' : '' }}>Irish</option>
                                <option value="Israeli" {{ old('nationality') == 'Israeli' ? 'selected' : '' }}>Israeli</option>
                                <option value="Italian" {{ old('nationality') == 'Italian' ? 'selected' : '' }}>Italian</option>
                                <option value="Ivorian" {{ old('nationality') == 'Ivorian' ? 'selected' : '' }}>Ivorian</option>
                                <option value="Jamaican" {{ old('nationality') == 'Jamaican' ? 'selected' : '' }}>Jamaican</option>
                                <option value="Japanese" {{ old('nationality') == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                <option value="Jordanian" {{ old('nationality') == 'Jordanian' ? 'selected' : '' }}>Jordanian</option>
                                <option value="Kazakhstani" {{ old('nationality') == 'Kazakhstani' ? 'selected' : '' }}>Kazakhstani</option>
                                <option value="Kenyan" {{ old('nationality') == 'Kenyan' ? 'selected' : '' }}>Kenyan</option>
                                <option value="Kittian and Nevisian" {{ old('nationality') == 'Kittian and Nevisian' ? 'selected' : '' }}>Kittian and Nevisian</option>
                                <option value="Kuwaiti" {{ old('nationality') == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                                <option value="Kyrgyz" {{ old('nationality') == 'Kyrgyz' ? 'selected' : '' }}>Kyrgyz</option>
                                <option value="Laotian" {{ old('nationality') == 'Laotian' ? 'selected' : '' }}>Laotian</option>
                                <option value="Latvian" {{ old('nationality') == 'Latvian' ? 'selected' : '' }}>Latvian</option>
                                <option value="Lebanese" {{ old('nationality') == 'Lebanese' ? 'selected' : '' }}>Lebanese</option>
                                <option value="Liberian" {{ old('nationality') == 'Liberian' ? 'selected' : '' }}>Liberian</option>
                                <option value="Libyan" {{ old('nationality') == 'Libyan' ? 'selected' : '' }}>Libyan</option>
                                <option value="Liechtensteiner" {{ old('nationality') == 'Liechtensteiner' ? 'selected' : '' }}>Liechtensteiner</option>
                                <option value="Lithuanian" {{ old('nationality') == 'Lithuanian' ? 'selected' : '' }}>Lithuanian</option>
                                <option value="Luxembourger" {{ old('nationality') == 'Luxembourger' ? 'selected' : '' }}>Luxembourger</option>
                                <option value="Macedonian" {{ old('nationality') == 'Macedonian' ? 'selected' : '' }}>Macedonian</option>
                                <option value="Malagasy" {{ old('nationality') == 'Malagasy' ? 'selected' : '' }}>Malagasy</option>
                                <option value="Malawian" {{ old('nationality') == 'Malawian' ? 'selected' : '' }}>Malawian</option>
                                <option value="Malaysian" {{ old('nationality') == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                                <option value="Maldivan" {{ old('nationality') == 'Maldivan' ? 'selected' : '' }}>Maldivan</option>
                                <option value="Malian" {{ old('nationality') == 'Malian' ? 'selected' : '' }}>Malian</option>
                                <option value="Maltese" {{ old('nationality') == 'Maltese' ? 'selected' : '' }}>Maltese</option>
                                <option value="Marshallese" {{ old('nationality') == 'Marshallese' ? 'selected' : '' }}>Marshallese</option>
                                <option value="Mauritanian" {{ old('nationality') == 'Mauritanian' ? 'selected' : '' }}>Mauritanian</option>
                                <option value="Mauritian" {{ old('nationality') == 'Mauritian' ? 'selected' : '' }}>Mauritian</option>
                                <option value="Mexican" {{ old('nationality') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                                <option value="Micronesian" {{ old('nationality') == 'Micronesian' ? 'selected' : '' }}>Micronesian</option>
                                <option value="Moldovan" {{ old('nationality') == 'Moldovan' ? 'selected' : '' }}>Moldovan</option>
                                <option value="Monacan" {{ old('nationality') == 'Monacan' ? 'selected' : '' }}>Monacan</option>
                                <option value="Mongolian" {{ old('nationality') == 'Mongolian' ? 'selected' : '' }}>Mongolian</option>
                                <option value="Moroccan" {{ old('nationality') == 'Moroccan' ? 'selected' : '' }}>Moroccan</option>
                                <option value="Mosotho" {{ old('nationality') == 'Mosotho' ? 'selected' : '' }}>Mosotho</option>
                                <option value="Motswana" {{ old('nationality') == 'Motswana' ? 'selected' : '' }}>Motswana</option>
                                <option value="Mozambican" {{ old('nationality') == 'Mozambican' ? 'selected' : '' }}>Mozambican</option>
                                <option value="Namibian" {{ old('nationality') == 'Namibian' ? 'selected' : '' }}>Namibian</option>
                                <option value="Nauruan" {{ old('nationality') == 'Nauruan' ? 'selected' : '' }}>Nauruan</option>
                                <option value="Nepalese" {{ old('nationality') == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                                <option value="New Zealander" {{ old('nationality') == 'New Zealander' ? 'selected' : '' }}>New Zealander</option>
                                <option value="Nicaraguan" {{ old('nationality') == 'Nicaraguan' ? 'selected' : '' }}>Nicaraguan</option>
                                <option value="Nigerian" {{ old('nationality') == 'Nigerian' ? 'selected' : '' }}>Nigerian</option>
                                <option value="Nigerien" {{ old('nationality') == 'Nigerien' ? 'selected' : '' }}>Nigerien</option>
                                <option value="North Korean" {{ old('nationality') == 'North Korean' ? 'selected' : '' }}>North Korean</option>
                                <option value="Northern Irish" {{ old('nationality') == 'Northern Irish' ? 'selected' : '' }}>Northern Irish</option>
                                <option value="Norwegian" {{ old('nationality') == 'Norwegian' ? 'selected' : '' }}>Norwegian</option>
                                <option value="Omani" {{ old('nationality') == 'Omani' ? 'selected' : '' }}>Omani</option>
                                <option value="Pakistani" {{ old('nationality') == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                <option value="Palauan" {{ old('nationality') == 'Palauan' ? 'selected' : '' }}>Palauan</option>
                                <option value="Panamanian" {{ old('nationality') == 'Panamanian' ? 'selected' : '' }}>Panamanian</option>
                                <option value="Papua New Guinean" {{ old('nationality') == 'Papua New Guinean' ? 'selected' : '' }}>Papua New Guinean</option>
                                <option value="Paraguayan" {{ old('nationality') == 'Paraguayan' ? 'selected' : '' }}>Paraguayan</option>
                                <option value="Peruvian" {{ old('nationality') == 'Peruvian' ? 'selected' : '' }}>Peruvian</option>
                                <option value="Polish" {{ old('nationality') == 'Polish' ? 'selected' : '' }}>Polish</option>
                                <option value="Portuguese" {{ old('nationality') == 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                                <option value="Qatari" {{ old('nationality') == 'Qatari' ? 'selected' : '' }}>Qatari</option>
                                <option value="Romanian" {{ old('nationality') == 'Romanian' ? 'selected' : '' }}>Romanian</option>
                                <option value="Russian" {{ old('nationality') == 'Russian' ? 'selected' : '' }}>Russian</option>
                                <option value="Rwandan" {{ old('nationality') == 'Rwandan' ? 'selected' : '' }}>Rwandan</option>
                                <option value="Saint Lucian" {{ old('nationality') == 'Saint Lucian' ? 'selected' : '' }}>Saint Lucian</option>
                                <option value="Salvadoran" {{ old('nationality') == 'Salvadoran' ? 'selected' : '' }}>Salvadoran</option>
                                <option value="Samoan" {{ old('nationality') == 'Samoan' ? 'selected' : '' }}>Samoan</option>
                                <option value="San Marinese" {{ old('nationality') == 'San Marinese' ? 'selected' : '' }}>San Marinese</option>
                                <option value="Sao Tomean" {{ old('nationality') == 'Sao Tomean' ? 'selected' : '' }}>Sao Tomean</option>
                                <option value="Saudi" {{ old('nationality') == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                                <option value="Scottish" {{ old('nationality') == 'Scottish' ? 'selected' : '' }}>Scottish</option>
                                <option value="Senegalese" {{ old('nationality') == 'Senegalese' ? 'selected' : '' }}>Senegalese</option>
                                <option value="Serbian" {{ old('nationality') == 'Serbian' ? 'selected' : '' }}>Serbian</option>
                                <option value="Seychellois" {{ old('nationality') == 'Seychellois' ? 'selected' : '' }}>Seychellois</option>
                                <option value="Sierra Leonean" {{ old('nationality') == 'Sierra Leonean' ? 'selected' : '' }}>Sierra Leonean</option>
                                <option value="Singaporean" {{ old('nationality') == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                                <option value="Slovakian" {{ old('nationality') == 'Slovakian' ? 'selected' : '' }}>Slovakian</option>
                                <option value="Slovenian" {{ old('nationality') == 'Slovenian' ? 'selected' : '' }}>Slovenian</option>
                                <option value="Solomon Islander" {{ old('nationality') == 'Solomon Islander' ? 'selected' : '' }}>Solomon Islander</option>
                                <option value="Somali" {{ old('nationality') == 'Somali' ? 'selected' : '' }}>Somali</option>
                                <option value="South African" {{ old('nationality') == 'South African' ? 'selected' : '' }}>South African</option>
                                <option value="South Korean" {{ old('nationality') == 'South Korean' ? 'selected' : '' }}>South Korean</option>
                                <option value="Spanish" {{ old('nationality') == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                <option value="Sri Lankan" {{ old('nationality') == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                <option value="Sudanese" {{ old('nationality') == 'Sudanese' ? 'selected' : '' }}>Sudanese</option>
                                <option value="Surinamer" {{ old('nationality') == 'Surinamer' ? 'selected' : '' }}>Surinamer</option>
                                <option value="Swazi" {{ old('nationality') == 'Swazi' ? 'selected' : '' }}>Swazi</option>
                                <option value="Swedish" {{ old('nationality') == 'Swedish' ? 'selected' : '' }}>Swedish</option>
                                <option value="Swiss" {{ old('nationality') == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                                <option value="Syrian" {{ old('nationality') == 'Syrian' ? 'selected' : '' }}>Syrian</option>
                                <option value="Taiwanese" {{ old('nationality') == 'Taiwanese' ? 'selected' : '' }}>Taiwanese</option>
                                <option value="Tajik" {{ old('nationality') == 'Tajik' ? 'selected' : '' }}>Tajik</option>
                                <option value="Tanzanian" {{ old('nationality') == 'Tanzanian' ? 'selected' : '' }}>Tanzanian</option>
                                <option value="Thai" {{ old('nationality') == 'Thai' ? 'selected' : '' }}>Thai</option>
                                <option value="Togolese" {{ old('nationality') == 'Togolese' ? 'selected' : '' }}>Togolese</option>
                                <option value="Tongan" {{ old('nationality') == 'Tongan' ? 'selected' : '' }}>Tongan</option>
                                <option value="Trinidadian or Tobagonian" {{ old('nationality') == 'Trinidadian or Tobagonian' ? 'selected' : '' }}>Trinidadian or Tobagonian</option>
                                <option value="Tunisian" {{ old('nationality') == 'Tunisian' ? 'selected' : '' }}>Tunisian</option>
                                <option value="Turkish" {{ old('nationality') == 'Turkish' ? 'selected' : '' }}>Turkish</option>
                                <option value="Tuvaluan" {{ old('nationality') == 'Tuvaluan' ? 'selected' : '' }}>Tuvaluan</option>
                                <option value="Ugandan" {{ old('nationality') == 'Ugandan' ? 'selected' : '' }}>Ugandan</option>
                                <option value="Ukrainian" {{ old('nationality') == 'Ukrainian' ? 'selected' : '' }}>Ukrainian</option>
                                <option value="Uruguayan" {{ old('nationality') == 'Uruguayan' ? 'selected' : '' }}>Uruguayan</option>
                                <option value="Uzbekistani" {{ old('nationality') == 'Uzbekistani' ? 'selected' : '' }}>Uzbekistani</option>
                                <option value="Venezuelan" {{ old('nationality') == 'Venezuelan' ? 'selected' : '' }}>Venezuelan</option>
                                <option value="Vietnamese" {{ old('nationality') == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                                <option value="Welsh" {{ old('nationality') == 'Welsh' ? 'selected' : '' }}>Welsh</option>
                                <option value="Yemenite" {{ old('nationality') == 'Yemenite' ? 'selected' : '' }}>Yemenite</option>
                                <option value="Zambian" {{ old('nationality') == 'Zambian' ? 'selected' : '' }}>Zambian</option>
                                <option value="Zimbabwean" {{ old('nationality') == 'Zimbabwean' ? 'selected' : '' }}>Zimbabwean</option>
                            </select>
                            @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="occupation" class="form-label fw-bold">
                                <i class="fas fa-briefcase me-1 text-primary"></i>Occupation
                            </label>
                            <input type="text" class="form-control form-control-lg @error('occupation') is-invalid @enderror" 
                                   id="occupation" name="occupation" value="{{ old('occupation') }}"
                                   placeholder="Enter occupation">
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Residence Permit Information -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-passport me-2"></i>
                    Residence Permit Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border-success">
                    <i class="fas fa-passport me-2 text-success"></i>
                    <strong>Residence Permit Details:</strong> Please provide accurate residence permit and passport information.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="passport_number" class="form-label fw-bold">
                                <i class="fas fa-id-card me-1 text-success"></i>Passport Number *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('passport_number') is-invalid @enderror" 
                                   id="passport_number" name="passport_number" value="{{ old('passport_number') }}" required
                                   placeholder="Enter passport number">
                            @error('passport_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="residence_permit_type" class="form-label fw-bold">
                                <i class="fas fa-id-card me-1 text-success"></i>Residence Permit Type *
                            </label>
                            <select class="form-select form-select-lg @error('residence_permit_type') is-invalid @enderror" id="residence_permit_type" name="residence_permit_type" required>
                                <option value="">Select Residence Permit Type</option>
                                <option value="ITK" {{ old('residence_permit_type') == 'ITK' ? 'selected' : '' }}>ITK - Izin Tinggal Kunjungan (Visit Permit)</option>
                                <option value="ITAS" {{ old('residence_permit_type') == 'ITAS' ? 'selected' : '' }}>ITAS - Izin Tinggal Sementara (Temporary Stay Permit)</option>
                                <option value="ITAP" {{ old('residence_permit_type') == 'ITAP' ? 'selected' : '' }}>ITAP - Izin Tinggal Tetap (Permanent Stay Permit)</option>
                                <option value="other" {{ old('residence_permit_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('residence_permit_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="residence_permit_expiry_date" class="form-label fw-bold">
                                <i class="fas fa-calendar-times me-1 text-success"></i>Residence Permit Expiry Date *
                            </label>
                            <input type="date" class="form-control form-control-lg @error('residence_permit_expiry_date') is-invalid @enderror" 
                                   id="residence_permit_expiry_date" name="residence_permit_expiry_date" value="{{ old('residence_permit_expiry_date') }}">
                            @error('residence_permit_expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="entry_point" class="form-label fw-bold">
                                <i class="fas fa-plane-arrival me-1 text-success"></i>Entry Point
                            </label>
                            <input type="text" class="form-control form-control-lg @error('entry_point') is-invalid @enderror" 
                                   id="entry_point" name="entry_point" value="{{ old('entry_point') }}"
                                   placeholder="e.g., Soekarno-Hatta Airport">
                            @error('entry_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">
                                <i class="fas fa-check-circle me-1 text-success"></i>Current Status *
                            </label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="expiring_soon" {{ old('status') == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon (≤30 days)</option>
                                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold">
                                <i class="fas fa-sticky-note me-1 text-success"></i>Notes
                            </label>
                            <textarea class="form-control form-control-lg @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" placeholder="Any additional notes about the residence permit or status">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-lg" onclick="document.getElementById('address-section').scrollIntoView({behavior: 'smooth'})">
                        Continue to Address <i class="fas fa-arrow-down ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 3: Address Information -->
        <div class="card mb-4" id="address-section">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Address Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border-info">
                    <i class="fas fa-home me-2 text-info"></i>
                    <strong>Current Address:</strong> Please provide your current residential address in Indonesia.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="country" class="form-label fw-bold">
                                <i class="fas fa-globe me-1 text-info"></i>Country *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('country') is-invalid @enderror" 
                                   id="country" name="country" value="{{ old('country', 'Indonesia') }}" required
                                   placeholder="Enter country">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label fw-bold">
                                <i class="fas fa-city me-1 text-info"></i>City/Regency *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" required
                                   placeholder="Enter city or regency">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="state_province" class="form-label fw-bold">
                                <i class="fas fa-map me-1 text-info"></i>Subdistrict *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('state_province') is-invalid @enderror" 
                                   id="state_province" name="state_province" value="{{ old('state_province') }}" required
                                   placeholder="Enter subdistrict">
                            @error('state_province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="village" class="form-label fw-bold">
                                <i class="fas fa-home me-1 text-info"></i>Village/Kelurahan *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('village') is-invalid @enderror" 
                                   id="village" name="village" value="{{ old('village') }}" required
                                   placeholder="Enter village or kelurahan">
                            @error('village')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="current_address" class="form-label fw-bold">
                                <i class="fas fa-address-card me-1 text-info"></i>Street Address *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('current_address') is-invalid @enderror" 
                                   id="current_address" name="current_address" value="{{ old('current_address') }}" required
                                   placeholder="Enter complete street address">
                            @error('current_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="postal_code" class="form-label fw-bold">
                                <i class="fas fa-mail-bulk me-1 text-info"></i>Postal Code *
                            </label>
                            <input type="text" class="form-control form-control-lg @error('postal_code') is-invalid @enderror" 
                                   id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required
                                   placeholder="Enter postal code">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info btn-lg" onclick="document.getElementById('location-section').scrollIntoView({behavior: 'smooth'})">
                        Continue to Location <i class="fas fa-arrow-down ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 4: Location Mapping -->
        <div class="card mb-4" id="location-section">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-globe me-2"></i>
                    Location Mapping
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border-warning">
                    <i class="fas fa-map-marked-alt me-2 text-warning"></i>
                    <strong>Location Coordinates:</strong> Click on the map or search for a location to set coordinates.
                </div>

                <!-- Location Search -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">
                                <i class="fas fa-search text-warning"></i>
                            </span>
                            <input type="text" class="form-control" id="location_search" 
                                   placeholder="Search for a location (e.g., Jl. Sudirman, Jakarta)">
                            <button class="btn btn-warning" type="button" onclick="searchLocation()">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-warning btn-lg" onclick="getCurrentLocation()">
                                <i class="fas fa-crosshairs me-2"></i>Use Current Location
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Map Container -->
                <div class="row">
                    <div class="col-md-12">
                        <div id="map" style="height: 400px; border-radius: 8px; border: 2px solid #ffc107;"></div>
                    </div>
                </div>

                <!-- Coordinate Display -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="latitude_display" class="form-label fw-bold">
                                <i class="fas fa-map-pin me-1 text-warning"></i>Latitude
                            </label>
                            <input type="text" class="form-control form-control-lg" id="latitude_display" readonly
                                   placeholder="Click on map to set latitude">
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="longitude_display" class="form-label fw-bold">
                                <i class="fas fa-map-pin me-1 text-warning"></i>Longitude
                            </label>
                            <input type="text" class="form-control form-control-lg" id="longitude_display" readonly
                                   placeholder="Click on map to set longitude">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning btn-lg" onclick="document.getElementById('contact-section').scrollIntoView({behavior: 'smooth'})">
                        Continue to Contact <i class="fas fa-arrow-down ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 5: Contact Information -->
        <div class="card mb-4" id="contact-section">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-phone me-2"></i>
                    Contact Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light border-secondary">
                    <i class="fas fa-address-book me-2 text-secondary"></i>
                    <strong>Contact Details:</strong> Provide contact information for communication and emergency purposes.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope me-1 text-secondary"></i>Email Address
                            </label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}"
                                   placeholder="Enter email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label fw-bold">
                                <i class="fas fa-phone me-1 text-secondary"></i>Phone Number
                            </label>
                            <input type="tel" class="form-control form-control-lg @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                   placeholder="e.g., +62812345678">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sponsor_contact_name" class="form-label fw-bold">
                                <i class="fas fa-user-tie me-1 text-secondary"></i>Sponsor Contact Name
                            </label>
                            <input type="text" class="form-control form-control-lg @error('sponsor_contact_name') is-invalid @enderror" 
                                   id="sponsor_contact_name" name="sponsor_contact_name" value="{{ old('sponsor_contact_name') }}"
                                   placeholder="Enter sponsor contact name">
                            @error('sponsor_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sponsor_contact_number" class="form-label fw-bold">
                                <i class="fas fa-phone-alt me-1 text-secondary"></i>Sponsor Contact Number
                            </label>
                            <input type="tel" class="form-control form-control-lg @error('sponsor_contact_number') is-invalid @enderror" 
                                   id="sponsor_contact_number" name="sponsor_contact_number" value="{{ old('sponsor_contact_number') }}"
                                   placeholder="Enter sponsor contact number">
                            @error('sponsor_contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Hidden required fields for validation -->
                <input type="hidden" name="entry_date" value="{{ date('Y-m-d') }}">
                <input type="hidden" name="residence_permit_status" value="Active">

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save me-2"></i>Save Foreign National
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@section('styles')
<style>
/* Enhanced Form Styling */
.form-control-lg, .form-select-lg {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus, .form-select-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-lg {
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Card Enhancements */
.card {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: none;
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header {
    border-bottom: none;
    padding: 20px;
}

.card-header h5 {
    font-size: 1.25rem;
    font-weight: 600;
}

.card-body {
    padding: 30px;
}

/* Alert Styling */
.alert {
    border-radius: 8px;
    border-width: 2px;
    margin-bottom: 25px;
}

/* Section Overview */
.alert-info {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

.alert-info i {
    display: block;
    margin-bottom: 0.5rem;
}

/* Form Section Animations */
.card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 20px;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 10px;
    }
}

/* Map Styling */
#map {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Input Group Enhancements */
.input-group-lg .input-group-text {
    border-radius: 8px 0 0 8px;
    border: 2px solid #e9ecef;
    border-right: none;
}

.input-group-lg .form-control {
    border-left: none;
    border-radius: 0;
}

.input-group-lg .btn {
    border-radius: 0 8px 8px 0;
    border: 2px solid #ffc107;
    border-left: none;
}

/* Smooth Scrolling Enhancement */
html {
    scroll-behavior: smooth;
}

/* Section Navigation Button Styling */
.card .btn[onclick*="scrollIntoView"] {
    background: linear-gradient(45deg, var(--bs-btn-bg), rgba(255,255,255,0.1));
    border: none;
    font-size: 0.9rem;
}
</style>
@endsection

@push('scripts')
<script>
// Initialize map when page loads
document.addEventListener('DOMContentLoaded', function() {
    initLeafletMap();
    
    // Handle residence permit type changes
    const permitTypeSelect = document.getElementById('residence_permit_type');
    const expiryDateField = document.getElementById('residence_permit_expiry_date');
    const expiryDateLabel = document.querySelector('label[for="residence_permit_expiry_date"]');
    
    function toggleExpiryDate() {
        if (!permitTypeSelect || !expiryDateField || !expiryDateLabel) {
            console.error('Required form elements not found for ITAP toggle');
            return;
        }
        
        if (permitTypeSelect.value === 'ITAP') {
            // ITAP is permanent, so no expiry date needed
            expiryDateField.removeAttribute('required');
            expiryDateField.value = '';
            expiryDateField.disabled = true;
            expiryDateLabel.innerHTML = '<i class="fas fa-calendar-times me-1 text-success"></i>Residence Permit Expiry Date <small class="text-muted">(Not required for permanent permits)</small>';
        } else {
            // Other types need expiry date
            expiryDateField.setAttribute('required', 'required');
            expiryDateField.disabled = false;
            expiryDateLabel.innerHTML = '<i class="fas fa-calendar-times me-1 text-success"></i>Residence Permit Expiry Date *';
        }
    }
    
    // Initial check
    toggleExpiryDate();
    
    // Add required attribute by default if not ITAP
    if (permitTypeSelect.value !== 'ITAP' && permitTypeSelect.value !== '') {
        expiryDateField.setAttribute('required', 'required');
    }
    
    // Add event listener
    permitTypeSelect.addEventListener('change', toggleExpiryDate);
});

// Map functionality using Leaflet
let map, marker;

function initLeafletMap() {
    try {
        // Fix Leaflet marker icon paths
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            shadowRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
        });
        
        // Default to Jakarta coordinates
        const defaultLocation = [-6.2088, 106.8456];
        
        // Initialize map
        map = L.map('map').setView(defaultLocation, 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Add click listener
        map.on('click', function(e) {
            setMarker(e.latlng);
        });
        
        // Initialize with default marker
        setMarker(L.latLng(defaultLocation[0], defaultLocation[1]));
        
        console.log('Leaflet map initialized successfully');
        
    } catch (error) {
        console.error('Error initializing map:', error);
        showMapError();
    }
}

// Add debouncing variable for reverse geocoding
let reverseGeocodeTimeout;

function setMarker(latlng) {
    if (marker) {
        // Remove existing marker and its event listeners
        marker.off(); // Remove all event listeners
        map.removeLayer(marker);
    }
    
    marker = L.marker(latlng, {
        draggable: true,
        title: 'Click and drag to adjust location'
    }).addTo(map);
    
    // Update coordinate displays
    updateCoordinateDisplays(latlng.lat, latlng.lng);
    
    // Perform reverse geocoding to get address (with debouncing)
    debouncedReverseGeocode(latlng.lat, latlng.lng);
    
    // Add drag listener (only once)
    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        updateCoordinateDisplays(pos.lat, pos.lng);
        // Also reverse geocode when marker is dragged (with debouncing)
        debouncedReverseGeocode(pos.lat, pos.lng);
    });
    
    // Add popup with coordinates
    marker.bindPopup(`Location: ${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}`);
}

function updateCoordinateDisplays(lat, lng) {
    document.getElementById('latitude_display').value = lat.toFixed(6);
    document.getElementById('longitude_display').value = lng.toFixed(6);
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}

function debouncedReverseGeocode(lat, lng) {
    // Clear any existing timeout to debounce the calls
    if (reverseGeocodeTimeout) {
        clearTimeout(reverseGeocodeTimeout);
    }
    
    // Set a new timeout to execute reverse geocoding after 500ms
    reverseGeocodeTimeout = setTimeout(() => {
        reverseGeocode(lat, lng);
    }, 500);
}

function reverseGeocode(lat, lng) {
    // Prevent multiple simultaneous calls
    if (reverseGeocode.isRunning) {
        return;
    }
    
    reverseGeocode.isRunning = true;
    
    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1&accept-language=en`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'User-Agent': 'ImmiTrace Dashboard/1.0 (Laravel Application)',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data && data.display_name) {
            // Update the search bar with the address
            const searchInput = document.getElementById('location_search');
            // Format the address to show relevant parts (exclude country and postal code details)
            const addressParts = data.display_name.split(',');
            const relevantParts = addressParts.slice(0, 3).join(',').trim();
            searchInput.value = relevantParts;
            
            // Update the popup with the address
            if (marker) {
                marker.bindPopup(`
                    <div style="max-width: 200px;">
                        <strong>Location:</strong><br>
                        ${relevantParts}<br>
                        <small>Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}</small>
                    </div>
                `);
            }
        }
    })
    .catch(error => {
        console.log('Reverse geocoding failed:', error);
        // Fallback: just show coordinates in search bar
        const searchInput = document.getElementById('location_search');
        searchInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    })
    .finally(() => {
        // Reset the running flag
        reverseGeocode.isRunning = false;
    });
}

function searchLocation() {
    const searchTerm = document.getElementById('location_search').value;
    if (!searchTerm) {
        alert('Please enter a location to search.');
        return;
    }
    
    // Show loading state
    const searchBtn = document.querySelector('button[onclick="searchLocation()"]');
    const originalText = searchBtn.innerHTML;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Searching...';
    searchBtn.disabled = true;
    
    // Try primary search method first
    searchWithNominatim(searchTerm)
        .then(result => {
            searchBtn.innerHTML = originalText;
            searchBtn.disabled = false;
            
            if (result) {
                map.setView(result.latlng, 16);
                setMarker(result.latlng);
                showToast('Location found: ' + result.name, 'success');
            } else {
                // If no results, try alternative method
                searchWithAlternative(searchTerm, searchBtn, originalText);
            }
        })
        .catch(error => {
            console.error('Primary search failed:', error);
            // Try alternative method
            searchWithAlternative(searchTerm, searchBtn, originalText);
        });
}

function searchWithNominatim(searchTerm) {
    const query = encodeURIComponent(searchTerm + ', Indonesia');
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=id&limit=1&addressdetails=1`;
    
    return fetch(url, {
        method: 'GET',
        headers: {
            'User-Agent': 'ImmiTrace Dashboard/1.0 (Laravel Application)',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Nominatim response:', data);
        
        if (data && data.length > 0) {
            const result = data[0];
            const lat = parseFloat(result.lat);
            const lng = parseFloat(result.lon);
            
            if (isNaN(lat) || isNaN(lng)) {
                throw new Error('Invalid coordinates received');
            }
            
            const locationName = result.display_name ? 
                result.display_name.split(',').slice(0, 2).join(',') : 
                `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                
            return {
                latlng: L.latLng(lat, lng),
                name: locationName
            };
        }
        return null;
    });
}

function searchWithAlternative(searchTerm, searchBtn, originalText) {
    // Use a simple coordinate-based fallback for major Indonesian cities
    const indonesianCities = {
        'jakarta': [-6.2088, 106.8456],
        'surabaya': [-7.2575, 112.7521],
        'bandung': [-6.9175, 107.6191],
        'medan': [3.5952, 98.6722],
        'semarang': [-6.9667, 110.4167],
        'makassar': [-5.1477, 119.4327],
        'palembang': [-2.9761, 104.7754],
        'tangerang': [-6.1783, 106.6319],
        'depok': [-6.4025, 106.7942],
        'bekasi': [-6.2383, 106.9756],
        'bogor': [-6.5971, 106.8060],
        'batam': [1.1307, 104.0530],
        'pekanbaru': [0.5071, 101.4478],
        'bandar lampung': [-5.3971, 105.2668],
        'malang': [-7.9797, 112.6304],
        'yogyakarta': [-7.7956, 110.3695],
        'solo': [-7.5663, 110.8281],
        'denpasar': [-8.6705, 115.2126],
        'balikpapan': [-1.2379, 116.8529],
        'samarinda': [-0.5017, 117.1536]
    };
    
    const searchLower = searchTerm.toLowerCase();
    let found = false;
    
    for (const [city, coords] of Object.entries(indonesianCities)) {
        if (searchLower.includes(city) || city.includes(searchLower.split(' ')[0])) {
            const latlng = L.latLng(coords[0], coords[1]);
            map.setView(latlng, 13);
            setMarker(latlng);
            
            searchBtn.innerHTML = originalText;
            searchBtn.disabled = false;
            
            showToast(`Found ${city.charAt(0).toUpperCase() + city.slice(1)} (approximate location)`, 'success');
            found = true;
            break;
        }
    }
    
    if (!found) {
        searchBtn.innerHTML = originalText;
        searchBtn.disabled = false;
        
        alert(`Location "${searchTerm}" not found. Try:\n• More specific terms (e.g., "Jalan Sudirman Jakarta")\n• Major city names (Jakarta, Surabaya, Bandung, etc.)\n• Click on the map to set location manually`);
    }
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser.');
        return;
    }
    
    // Show loading state
    const currentBtn = document.querySelector('button[onclick="getCurrentLocation()"]');
    const originalText = currentBtn.innerHTML;
    currentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Getting Location...';
    currentBtn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            // Reset button
            currentBtn.innerHTML = originalText;
            currentBtn.disabled = false;
            
            const latlng = L.latLng(position.coords.latitude, position.coords.longitude);
            map.setView(latlng, 16);
            setMarker(latlng);
            
            showToast('Current location found!', 'success');
        },
        function(error) {
            // Reset button
            currentBtn.innerHTML = originalText;
            currentBtn.disabled = false;
            
            let errorMessage = 'Unable to get your current location.';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'Location access denied by user.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'Location information is unavailable.';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'Location request timed out.';
                    break;
            }
            alert(errorMessage);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
}

function showMapError() {
    const mapContainer = document.getElementById('map');
    mapContainer.innerHTML = `
        <div class="d-flex align-items-center justify-content-center h-100 bg-light border-warning border-2 rounded">
            <div class="text-center p-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5 class="text-warning">Map Unavailable</h5>
                <p class="text-muted mb-3">The map could not be loaded. This may be due to:</p>
                <ul class="text-start text-muted small">
                    <li>Network connectivity issues</li>
                    <li>JavaScript errors</li>
                    <li>Browser compatibility issues</li>
                </ul>
                <p class="text-muted small mt-3">
                    <strong>Note:</strong> You can still manually enter coordinates in the fields below.
                </p>
            </div>
        </div>
    `;
    
    // Enable manual coordinate entry
    document.getElementById('latitude_display').removeAttribute('readonly');
    document.getElementById('longitude_display').removeAttribute('readonly');
    document.getElementById('latitude_display').placeholder = 'Enter latitude manually';
    document.getElementById('longitude_display').placeholder = 'Enter longitude manually';
    
    // Add event listeners for manual entry
    document.getElementById('latitude_display').addEventListener('input', function() {
        document.getElementById('latitude').value = this.value;
    });
    document.getElementById('longitude_display').addEventListener('input', function() {
        document.getElementById('longitude').value = this.value;
    });
}

// Form validation enhancement
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            valid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!valid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        // Scroll to first invalid field
        const firstInvalid = this.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.focus();
        }
    }
});

// Enhanced search with Enter key support
document.getElementById('location_search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchLocation();
    }
});

// Helper function for toast notifications (if available)
function showToast(message, type) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        console.log(`${type.toUpperCase()}: ${message}`);
    }
}
</script>
@endpush
