@extends('layouts.app')

@section('title', 'Tambah Data WNA Baru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2"></i>
        Tambah Data WNA Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Daftar
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Harap perbaiki kesalahan berikut:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Personal Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('foreigners.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
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
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nationality *</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                                    <option value="">Select Nationality</option>
                                    <option value="Afghan" {{ old('nationality') == 'Afghan' ? 'selected' : '' }}>Afghan</option>
                                    <option value="Albanian" {{ old('nationality') == 'Albanian' ? 'selected' : '' }}>Albanian</option>
                                    <option value="Algerian" {{ old('nationality') == 'Algerian' ? 'selected' : '' }}>Algerian</option>
                                    <option value="American" {{ old('nationality') == 'American' ? 'selected' : '' }}>American</option>
                                    <option value="Andorran" {{ old('nationality') == 'Andorran' ? 'selected' : '' }}>Andorran</option>
                                    <option value="Angolan" {{ old('nationality') == 'Angolan' ? 'selected' : '' }}>Angolan</option>
                                    <option value="Antiguan" {{ old('nationality') == 'Antiguan' ? 'selected' : '' }}>Antiguan</option>
                                    <option value="Argentine" {{ old('nationality') == 'Argentine' ? 'selected' : '' }}>Argentine</option>
                                    <option value="Armenian" {{ old('nationality') == 'Armenian' ? 'selected' : '' }}>Armenian</option>
                                    <option value="Australian" {{ old('nationality') == 'Australian' ? 'selected' : '' }}>Australian</option>
                                    <option value="Austrian" {{ old('nationality') == 'Austrian' ? 'selected' : '' }}>Austrian</option>
                                    <option value="Azerbaijani" {{ old('nationality') == 'Azerbaijani' ? 'selected' : '' }}>Azerbaijani</option>
                                    <option value="Bahamian" {{ old('nationality') == 'Bahamian' ? 'selected' : '' }}>Bahamian</option>
                                    <option value="Bahraini" {{ old('nationality') == 'Bahraini' ? 'selected' : '' }}>Bahraini</option>
                                    <option value="Bangladeshi" {{ old('nationality') == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                                    <option value="Barbadian" {{ old('nationality') == 'Barbadian' ? 'selected' : '' }}>Barbadian</option>
                                    <option value="Belarusian" {{ old('nationality') == 'Belarusian' ? 'selected' : '' }}>Belarusian</option>
                                    <option value="Belgian" {{ old('nationality') == 'Belgian' ? 'selected' : '' }}>Belgian</option>
                                    <option value="Belizean" {{ old('nationality') == 'Belizean' ? 'selected' : '' }}>Belizean</option>
                                    <option value="Beninese" {{ old('nationality') == 'Beninese' ? 'selected' : '' }}>Beninese</option>
                                    <option value="Bhutanese" {{ old('nationality') == 'Bhutanese' ? 'selected' : '' }}>Bhutanese</option>
                                    <option value="Bolivian" {{ old('nationality') == 'Bolivian' ? 'selected' : '' }}>Bolivian</option>
                                    <option value="Bosnian" {{ old('nationality') == 'Bosnian' ? 'selected' : '' }}>Bosnian</option>
                                    <option value="Botswanan" {{ old('nationality') == 'Botswanan' ? 'selected' : '' }}>Botswanan</option>
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
                                    <option value="Djiboutian" {{ old('nationality') == 'Djiboutian' ? 'selected' : '' }}>Djiboutian</option>
                                    <option value="Dominican" {{ old('nationality') == 'Dominican' ? 'selected' : '' }}>Dominican</option>
                                    <option value="Dutch" {{ old('nationality') == 'Dutch' ? 'selected' : '' }}>Dutch</option>
                                    <option value="East Timorese" {{ old('nationality') == 'East Timorese' ? 'selected' : '' }}>East Timorese</option>
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
                                    <option value="Luxembourgish" {{ old('nationality') == 'Luxembourgish' ? 'selected' : '' }}>Luxembourgish</option>
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
                                    <option value="Ni-Vanuatu" {{ old('nationality') == 'Ni-Vanuatu' ? 'selected' : '' }}>Ni-Vanuatu</option>
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
                                    <option value="Surinamese" {{ old('nationality') == 'Surinamese' ? 'selected' : '' }}>Surinamese</option>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="passport_number" class="form-label">Passport Number</label>
                                <input type="text" class="form-control @error('passport_number') is-invalid @enderror" 
                                       id="passport_number" name="passport_number" value="{{ old('passport_number') }}">
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
                            <div class="mb-3">
                                <label class="form-label">Preview Foto</label>
                                <div id="photo-preview" class="card border text-center p-3" style="height: 150px; display: none;">
                                    <img id="preview-image" src="" alt="Preview" style="height: 100%; object-fit: cover;">
                                </div>
                                <div id="photo-placeholder" class="card border text-center p-3" style="height: 150px;">
                                    <i class="fas fa-camera fa-3x text-muted mb-2"></i>
                                    <small class="text-muted">Pilih foto untuk preview</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">
                        <i class="fas fa-id-card me-2"></i>
                        Visa Information
                    </h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_type" class="form-label">Visa Type *</label>
                                <select class="form-select @error('visa_type') is-invalid @enderror" id="visa_type" name="visa_type" required>
                                    <option value="">Select Visa Type</option>
                                    <option value="Tourist" {{ old('visa_type') == 'Tourist' ? 'selected' : '' }}>Tourist</option>
                                    <option value="Business" {{ old('visa_type') == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Student" {{ old('visa_type') == 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Work" {{ old('visa_type') == 'Work' ? 'selected' : '' }}>Work</option>
                                    <option value="Transit" {{ old('visa_type') == 'Transit' ? 'selected' : '' }}>Transit</option>
                                    <option value="Diplomatic" {{ old('visa_type') == 'Diplomatic' ? 'selected' : '' }}>Diplomatic</option>
                                </select>
                                @error('visa_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_status" class="form-label">Visa Status *</label>
                                <select class="form-select @error('visa_status') is-invalid @enderror" id="visa_status" name="visa_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active" {{ old('visa_status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Expired" {{ old('visa_status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="Pending" {{ old('visa_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Cancelled" {{ old('visa_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                                       id="entry_date" name="entry_date" value="{{ old('entry_date') }}">
                                @error('entry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visa_expiry" class="form-label">Visa Expiry Date</label>
                                <input type="date" class="form-control @error('visa_expiry') is-invalid @enderror" 
                                       id="visa_expiry" name="visa_expiry" value="{{ old('visa_expiry') }}">
                                @error('visa_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Location Information
                    </h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_address" class="form-label">Current Address *</label>
                                <textarea class="form-control @error('current_address') is-invalid @enderror" 
                                          id="current_address" name="current_address" rows="3" required>{{ old('current_address') }}</textarea>
                                @error('current_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city_regency" class="form-label">Kota/Kabupaten *</label>
                                <select class="form-select @error('city_regency') is-invalid @enderror" id="city_regency" name="city_regency" required onchange="updateSubdistricts()">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    <option value="Kota Cirebon" {{ old('city_regency') == 'Kota Cirebon' ? 'selected' : '' }}>Kota Cirebon</option>
                                    <option value="Kabupaten Cirebon" {{ old('city_regency') == 'Kabupaten Cirebon' ? 'selected' : '' }}>Kabupaten Cirebon</option>
                                    <option value="Kota Kuningan" {{ old('city_regency') == 'Kota Kuningan' ? 'selected' : '' }}>Kota Kuningan</option>
                                    <option value="Kabupaten Kuningan" {{ old('city_regency') == 'Kabupaten Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                                    <option value="Kota Indramayu" {{ old('city_regency') == 'Kota Indramayu' ? 'selected' : '' }}>Kota Indramayu</option>
                                    <option value="Kabupaten Indramayu" {{ old('city_regency') == 'Kabupaten Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                                    <option value="Kota Majalengka" {{ old('city_regency') == 'Kota Majalengka' ? 'selected' : '' }}>Kota Majalengka</option>
                                    <option value="Kabupaten Majalengka" {{ old('city_regency') == 'Kabupaten Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                                </select>
                                @error('city_regency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subdistrict" class="form-label">Kecamatan *</label>
                                <select class="form-select @error('subdistrict') is-invalid @enderror" id="subdistrict" name="subdistrict" required onchange="updateVillages()">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="village" class="form-label">Kelurahan/Desa *</label>
                                <select class="form-select @error('village') is-invalid @enderror" id="village" name="village" required>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                                @error('village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}" 
                                       placeholder="Masukkan kode pos (opsional)">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Empty column for layout balance -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude (Auto-generated)</label>
                                <input type="number" step="0.000001" class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" name="latitude" value="{{ old('latitude') }}" readonly>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude (Auto-generated)</label>
                                <input type="number" step="0.000001" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude') }}" readonly>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <button type="button" class="btn btn-info" id="generateCoordinates" onclick="generateCoordinatesFromAddress()">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Generate Coordinates from Location
                                </button>
                                <small class="text-muted ms-2">Click after selecting City/Regency, Subdistrict, and Village</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">
                        <i class="fas fa-phone me-2"></i>
                        Contact Information
                    </h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <textarea class="form-control @error('emergency_contact') is-invalid @enderror" 
                                  id="emergency_contact" name="emergency_contact" rows="2" 
                                  placeholder="Name, relationship, phone number">{{ old('emergency_contact') }}</textarea>
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('foreigners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Save Foreigner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Form Guidelines
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-asterisk text-danger me-2" style="font-size: 0.7em;"></i>
                        Fields marked with <span class="text-danger">*</span> are required
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-info"></i>
                        Coordinates auto-generated from location data
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-location-arrow me-2 text-primary"></i>
                        Select City/Regency → Subdistrict → Village, then generate coordinates
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-building me-2 text-success"></i>
                        Village dropdown populates based on selected subdistrict
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-passport me-2 text-warning"></i>
                        Passport number should be unique
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-calendar me-2 text-secondary"></i>
                        Check visa expiry dates carefully
                    </li>
                </ul>

                <hr>

                <h6 class="mb-2">
                    <i class="fas fa-question-circle me-2"></i>
                    Need Help?
                </h6>
                <p class="text-muted small">
                    Contact the administrator if you need assistance with this form or have questions about data entry.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Photo preview functionality
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        const previewImage = document.getElementById('preview-image');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    });

    // Auto-focus first input
    document.getElementById('first_name').focus();
    
    // Form validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
            submitBtn.disabled = true;
        });
    });

    // Subdistrict data based on city/regency
    const subdistrictData = {
        'Kota Cirebon': [
            'Harjamukti',
            'Lemahwungkuk',
            'Pekalipan',
            'Kesambi',
            'Kejaksan'
        ],
        'Kabupaten Cirebon': [
            'Waled',
            'Pasaleman',
            'Ciledug',
            'Losari',
            'Pabedilan',
            'Babakan',
            'Karangsembung',
            'Ciwaringin',
            'Cidahu',
            'Klangenan',
            'Sedong',
            'Astanajapura',
            'Pangenan',
            'Mundu',
            'Beber',
            'Talun',
            'Sumber',
            'Dukupuntang',
            'Arjawinangun',
            'Tengah Tani',
            'Kaliwedi',
            'Gebang',
            'Kapetakan',
            'Kertasemaya',
            'Susukan Lebak',
            'Susukan',
            'Jamblang',
            'Pabedilan',
            'Plumbon',
            'Weru',
            'Palimanan',
            'Plered',
            'Gunungjati',
            'Cirebon Utara',
            'Cirebon Selatan',
            'Gunung Jati',
            'Suranenggala',
            'Kapetakan',
            'Gegesik'
        ],
        'Kota Kuningan': [
            'Kuningan',
            'Cigugur',
            'Cilimus'
        ],
        'Kabupaten Kuningan': [
            'Kuningan',
            'Cigugur',
            'Cilimus',
            'Ciwaru',
            'Cibingbin',
            'Kadugede',
            'Cigandamekar',
            'Kramatmulya',
            'Nusaherang',
            'Darma',
            'Luragung',
            'Cimahi',
            'Jalaksana',
            'Cipicung',
            'Garawangi',
            'Ciniru',
            'Mandirancan',
            'Ciawigebang',
            'Hantara',
            'Subang',
            'Pancalang',
            'Lebakwangi',
            'Selajambe'
        ],
        'Kota Indramayu': [
            'Indramayu',
            'Sindang',
            'Losarang'
        ],
        'Kabupaten Indramayu': [
            'Indramayu',
            'Sindang',
            'Losarang',
            'Kandanghaur',
            'Bongas',
            'Gabuswetan',
            'Tukdana',
            'Sliyeg',
            'Haurgeulis',
            'Kroya',
            'Krangkeng',
            'Widasari',
            'Patrol',
            'Sukra',
            'Gantar',
            'Terisi',
            'Sukagumiwang',
            'Karangampel',
            'Juntinyuat',
            'Arahan',
            'Jatibarang',
            'Balongan',
            'Anjatan',
            'Bangodua',
            'Cikedung',
            'Lelea',
            'Kedokan Bunder',
            'Cantigi',
            'Lohbener',
            'Pasekan',
            'Kertasemaya'
        ],
        'Kota Majalengka': [
            'Majalengka',
            'Cigasong',
            'Bantarujeg'
        ],
        'Kabupaten Majalengka': [
            'Majalengka',
            'Cigasong',
            'Bantarujeg',
            'Malausma',
            'Cikijing',
            'Cingambul',
            'Talaga',
            'Argapura',
            'Maja',
            'Rajagaluh',
            'Leuwimunding',
            'Jatiwangi',
            'Dawuan',
            'Kadipaten',
            'Kertajati',
            'Jatitujuh',
            'Ligung',
            'Sumberjaya',
            'Panyingkiran',
            'Sukahaji',
            'Sindang',
            'Sindangwangi',
            'Lemahsugih',
            'Banjaran',
            'Cipelah',
            'Kasokandel'
        ]
    };

    // Village/Kelurahan data based on city/regency and subdistrict
    const villageData = {
        'Kota Cirebon': {
            'Harjamukti': [
                'Harjamukti',
                'Kecapi',
                'Karyamulya',
                'Pegambiran'
            ],
            'Lemahwungkuk': [
                'Lemahwungkuk',
                'Panjunan',
                'Kasepuhan',
                'Pekalangan'
            ],
            'Pekalipan': [
                'Pekalipan',
                'Pulasaren',
                'Pekalangan',
                'Kebonbaru'
            ],
            'Kesambi': [
                'Kesambi',
                'Drajat',
                'Sukapura',
                'Kesunean'
            ],
            'Kejaksan': [
                'Kejaksan',
                'Kesenden',
                'Larangan',
                'Jagasatru'
            ]
        },
        'Kabupaten Cirebon': {
            'Waled': [
                'Waled',
                'Astapada',
                'Babakan Losari',
                'Banjar',
                'Bendungan',
                'Jatiseeng',
                'Kaliwadas',
                'Pegagan Lor',
                'Pegagan Kidul',
                'Sukadana'
            ],
            'Pasaleman': [
                'Pasaleman',
                'Cikarang',
                'Jatitujuh',
                'Kanci',
                'Karanganyar',
                'Munjul',
                'Panembahan',
                'Sukamulya'
            ],
            'Ciledug': [
                'Ciledug',
                'Babakan',
                'Karangmulya',
                'Ragajaya',
                'Sindangjawa',
                'Tegalsuci'
            ],
            'Losari': [
                'Losari',
                'Bangodua',
                'Jatimerta',
                'Karanganyar',
                'Sindangjawa',
                'Tangkil'
            ],
            'Sumber': [
                'Sumber',
                'Babakan Gebang',
                'Krangkeng',
                'Mundu',
                'Sindang',
                'Wanakerta'
            ],
            'Palimanan': [
                'Palimanan',
                'Ciperna',
                'Kertawirama',
                'Panembahan',
                'Sindang',
                'Tegalwangi'
            ],
            'Plered': [
                'Plered',
                'Jatiseeng',
                'Kaliwadas',
                'Rancabango',
                'Sedong',
                'Wanakerta'
            ],
            'Weru': [
                'Weru',
                'Astanajapura',
                'Karangsuwung',
                'Setupatok',
                'Wanakerta'
            ]
        },
        'Kota Kuningan': {
            'Kuningan': [
                'Kuningan',
                'Cigugur',
                'Windusengkahan',
                'Purwawinangun'
            ],
            'Cigugur': [
                'Cigugur',
                'Cisantana',
                'Sukamulya'
            ],
            'Cilimus': [
                'Cilimus',
                'Boyongbong',
                'Neglasari'
            ]
        },
        'Kabupaten Kuningan': {
            'Kuningan': [
                'Kuningan',
                'Cigugur',
                'Windusengkahan',
                'Purwawinangun',
                'Sukamulya',
                'Cisantana'
            ],
            'Cigugur': [
                'Cigugur',
                'Sukamulya',
                'Cisantana',
                'Neglasari'
            ],
            'Cilimus': [
                'Cilimus',
                'Boyongbong',
                'Neglasari',
                'Sukamulya'
            ],
            'Ciwaru': [
                'Ciwaru',
                'Babakanreuma',
                'Babakanjawa',
                'Ciwaru'
            ],
            'Darma': [
                'Darma',
                'Kertawirama',
                'Margaluyu',
                'Sindangagung'
            ],
            'Luragung': [
                'Luragung',
                'Garawangi',
                'Kadugede',
                'Neglasari'
            ]
        },
        'Kota Indramayu': {
            'Indramayu': [
                'Indramayu',
                'Karanganyar',
                'Margadadi',
                'Singajaya'
            ],
            'Sindang': [
                'Sindang',
                'Jatibarang',
                'Sukadana',
                'Tukdana'
            ],
            'Losarang': [
                'Losarang',
                'Karangampel',
                'Margadadi',
                'Sukadana'
            ]
        },
        'Kabupaten Indramayu': {
            'Indramayu': [
                'Indramayu',
                'Karanganyar',
                'Margadadi',
                'Singajaya',
                'Sukadana'
            ],
            'Sindang': [
                'Sindang',
                'Jatibarang',
                'Sukadana',
                'Tukdana',
                'Karangsong'
            ],
            'Losarang': [
                'Losarang',
                'Karangampel',
                'Margadadi',
                'Sukadana',
                'Tanjungsari'
            ],
            'Kandanghaur': [
                'Kandanghaur',
                'Bongas',
                'Sukadana',
                'Tukdana'
            ],
            'Jatibarang': [
                'Jatibarang',
                'Krangkeng',
                'Sukadana',
                'Tanjungsari'
            ],
            'Patrol': [
                'Patrol',
                'Karangampel',
                'Sukadana',
                'Tanjungsari'
            ]
        },
        'Kota Majalengka': {
            'Majalengka': [
                'Majalengka',
                'Tonjong',
                'Cicenang',
                'Babakan'
            ],
            'Cigasong': [
                'Cigasong',
                'Sukahaji',
                'Sindang'
            ],
            'Bantarujeg': [
                'Bantarujeg',
                'Sindang',
                'Sukahaji'
            ]
        },
        'Kabupaten Majalengka': {
            'Majalengka': [
                'Majalengka',
                'Tonjong',
                'Cicenang',
                'Babakan',
                'Sindang'
            ],
            'Cigasong': [
                'Cigasong',
                'Sukahaji',
                'Sindang',
                'Tonjong'
            ],
            'Jatiwangi': [
                'Jatiwangi',
                'Sukahaji',
                'Sindang',
                'Babakan'
            ],
            'Kadipaten': [
                'Kadipaten',
                'Sindang',
                'Sukahaji',
                'Tonjong'
            ],
            'Rajagaluh': [
                'Rajagaluh',
                'Sukahaji',
                'Sindang'
            ]
        }
    };

    // Function to update subdistricts based on selected city/regency
    function updateSubdistricts() {
        const cityRegency = document.getElementById('city_regency').value;
        const subdistrictSelect = document.getElementById('subdistrict');
        const villageSelect = document.getElementById('village');
        
        // Clear existing options
        subdistrictSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
        
        // Add new options based on selected city/regency
        if (cityRegency && subdistrictData[cityRegency]) {
            subdistrictData[cityRegency].forEach(function(subdistrict) {
                const option = document.createElement('option');
                option.value = subdistrict;
                option.textContent = subdistrict;
                // Check if this was the old selected value
                if ('{{ old("subdistrict") }}' === subdistrict) {
                    option.selected = true;
                }
                subdistrictSelect.appendChild(option);
            });
        }
        
        // Update villages if subdistrict was already selected
        if ('{{ old("subdistrict") }}') {
            updateVillages();
        }
        
        // Clear coordinates when city/regency changes
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
    }

    // Function to update villages based on selected city/regency and subdistrict
    function updateVillages() {
        const cityRegency = document.getElementById('city_regency').value;
        const subdistrict = document.getElementById('subdistrict').value;
        const villageSelect = document.getElementById('village');
        
        // Clear existing options
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
        
        // Add new options based on selected city/regency and subdistrict
        if (cityRegency && subdistrict && villageData[cityRegency] && villageData[cityRegency][subdistrict]) {
            villageData[cityRegency][subdistrict].forEach(function(village) {
                const option = document.createElement('option');
                option.value = village;
                option.textContent = village;
                // Check if this was the old selected value
                if ('{{ old("village") }}' === village) {
                    option.selected = true;
                }
                villageSelect.appendChild(option);
            });
        }
        
        // Clear coordinates when subdistrict changes
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
    }

    // Function to generate coordinates from administrative location
    async function generateCoordinatesFromAddress() {
        const cityRegency = document.getElementById('city_regency').value;
        const subdistrict = document.getElementById('subdistrict').value;
        const village = document.getElementById('village').value;
        const currentAddress = document.getElementById('current_address').value;
        
        if (!cityRegency || !subdistrict) {
            alert('Silakan pilih Kota/Kabupaten dan Kecamatan terlebih dahulu');
            return;
        }
        
        // Build address string for geocoding
        let addressParts = [];
        
        if (village) {
            addressParts.push(village);
        }
        addressParts.push(subdistrict);
        addressParts.push(cityRegency);
        addressParts.push('Jawa Barat, Indonesia');
        
        const fullAddress = addressParts.join(', ');
        
        const button = document.getElementById('generateCoordinates');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
        button.disabled = true;
        
        try {
            // Use Nominatim (OpenStreetMap) geocoding service
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}&limit=1&countrycodes=id`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                const latitude = parseFloat(data[0].lat);
                const longitude = parseFloat(data[0].lon);
                
                document.getElementById('latitude').value = latitude.toFixed(6);
                document.getElementById('longitude').value = longitude.toFixed(6);
                
                // Show success message
                showMessage('success', 'Koordinat berhasil dibuat dari lokasi administratif!');
            } else {
                // Fallback to predefined coordinates for major cities
                const fallbackCoordinates = getFallbackCoordinates(cityRegency, subdistrict);
                if (fallbackCoordinates) {
                    document.getElementById('latitude').value = fallbackCoordinates.lat;
                    document.getElementById('longitude').value = fallbackCoordinates.lng;
                    showMessage('warning', 'Menggunakan koordinat perkiraan untuk area ini.');
                } else {
                    showMessage('error', 'Tidak dapat menemukan koordinat untuk lokasi ini. Silakan coba lagi dengan informasi yang lebih spesifik.');
                }
            }
        } catch (error) {
            console.error('Geocoding error:', error);
            
            // Use fallback coordinates
            const fallbackCoordinates = getFallbackCoordinates(cityRegency, subdistrict);
            if (fallbackCoordinates) {
                document.getElementById('latitude').value = fallbackCoordinates.lat;
                document.getElementById('longitude').value = fallbackCoordinates.lng;
                showMessage('warning', 'Layanan geocoding tidak tersedia. Menggunakan koordinat perkiraan.');
            } else {
                showMessage('error', 'Tidak dapat menghasilkan koordinat. Silakan coba lagi nanti.');
            }
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    }
    
    // Fallback coordinates for major areas
    function getFallbackCoordinates(cityRegency, subdistrict) {
        const coordinates = {
            'Kota Cirebon': {
                'Harjamukti': { lat: -6.7063, lng: 108.5678 },
                'Lemahwungkuk': { lat: -6.7324, lng: 108.5516 },
                'Pekalipan': { lat: -6.7184, lng: 108.5406 },
                'Kesambi': { lat: -6.7058, lng: 108.5299 },
                'Kejaksan': { lat: -6.7275, lng: 108.5574 },
                'default': { lat: -6.7063, lng: 108.5500 }
            },
            'Kabupaten Cirebon': {
                'Waled': { lat: -6.9080, lng: 108.7126 },
                'Pasaleman': { lat: -6.8543, lng: 108.6891 },
                'Ciledug': { lat: -6.8234, lng: 108.6543 },
                'Losari': { lat: -6.7895, lng: 108.6234 },
                'Sumber': { lat: -6.7563, lng: 108.4891 },
                'Palimanan': { lat: -6.7089, lng: 108.4234 },
                'Plered': { lat: -6.6891, lng: 108.4567 },
                'Weru': { lat: -6.7234, lng: 108.4789 },
                'default': { lat: -6.8000, lng: 108.6000 }
            },
            'Kota Kuningan': {
                'Kuningan': { lat: -6.9764, lng: 108.4839 },
                'Cigugur': { lat: -6.9543, lng: 108.4621 },
                'Cilimus': { lat: -6.9891, lng: 108.5012 },
                'default': { lat: -6.9764, lng: 108.4839 }
            },
            'Kabupaten Kuningan': {
                'Kuningan': { lat: -6.9764, lng: 108.4839 },
                'Cigugur': { lat: -6.9543, lng: 108.4621 },
                'Cilimus': { lat: -6.9891, lng: 108.5012 },
                'Ciwaru': { lat: -7.0234, lng: 108.4567 },
                'Darma': { lat: -6.9123, lng: 108.4234 },
                'Luragung': { lat: -6.8891, lng: 108.4891 },
                'default': { lat: -6.9500, lng: 108.4700 }
            },
            'Kota Indramayu': {
                'Indramayu': { lat: -6.3267, lng: 108.3199 },
                'Sindang': { lat: -6.3456, lng: 108.3021 },
                'Losarang': { lat: -6.3891, lng: 108.3567 },
                'default': { lat: -6.3267, lng: 108.3199 }
            },
            'Kabupaten Indramayu': {
                'Indramayu': { lat: -6.3267, lng: 108.3199 },
                'Sindang': { lat: -6.3456, lng: 108.3021 },
                'Losarang': { lat: -6.3891, lng: 108.3567 },
                'Kandanghaur': { lat: -6.2891, lng: 108.4234 },
                'Bongas': { lat: -6.2567, lng: 108.3891 },
                'Haurgeulis': { lat: -6.1891, lng: 108.3234 },
                'Jatibarang': { lat: -6.4234, lng: 108.2567 },
                'Patrol': { lat: -6.3567, lng: 108.2891 },
                'default': { lat: -6.3000, lng: 108.3500 }
            },
            'Kota Majalengka': {
                'Majalengka': { lat: -6.8361, lng: 108.2278 },
                'Cigasong': { lat: -6.8567, lng: 108.2456 },
                'Bantarujeg': { lat: -6.8123, lng: 108.2891 },
                'default': { lat: -6.8361, lng: 108.2278 }
            },
            'Kabupaten Majalengka': {
                'Majalengka': { lat: -6.8361, lng: 108.2278 },
                'Cigasong': { lat: -6.8567, lng: 108.2456 },
                'Bantarujeg': { lat: -6.8123, lng: 108.2891 },
                'Jatiwangi': { lat: -6.7234, lng: 108.2567 },
                'Kadipaten': { lat: -6.8891, lng: 108.1567 },
                'Dawuan': { lat: -6.7567, lng: 108.1891 },
                'Rajagaluh': { lat: -6.9234, lng: 108.2123 },
                'default': { lat: -6.8500, lng: 108.2000 }
            }
        };
        
        if (coordinates[cityRegency]) {
            return coordinates[cityRegency][subdistrict] || coordinates[cityRegency]['default'];
        }
        
        return null;
    }
    
    // Function to show messages
    function showMessage(type, message) {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.coordinate-message');
        existingMessages.forEach(msg => msg.remove());
        
        // Create new message
        const messageDiv = document.createElement('div');
        messageDiv.className = `alert alert-${type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'danger'} coordinate-message mt-2`;
        messageDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>${message}`;
        
        // Insert after the generate button
        const button = document.getElementById('generateCoordinates');
        button.parentNode.insertBefore(messageDiv, button.nextSibling);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }

    // Initialize subdistricts and villages on page load if city/regency is already selected
    document.addEventListener('DOMContentLoaded', function() {
        updateSubdistricts();
        updateVillages();
    });
</script>
@endpush
