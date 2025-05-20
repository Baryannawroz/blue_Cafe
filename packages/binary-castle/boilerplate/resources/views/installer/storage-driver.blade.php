@extends('boilerplate::installer.base')

@section('title')
    Storage Management
@endsection

@section('content')
    <div class="d-flex justify-content-center">
        <form method="post" action="{{ route('installer.save.storage') }}" class="d-flex flex-wrap w-100">
            @csrf
            <div class="col-4">
                <h1>Storage</h1>
                <p>Decide where to place your log.</p>
                <hr>
                <p id="localStorageDetails">
                    <b>Local Storage:</b> <br>
                    When you use local storage, all the images, videos, and files you upload are stored on the server
                    where your application is installed. This means that the files reside directly on the server's file
                    system. You can access these files using your domain followed by the specific file path and
                    extension (e.g., yourdomain.com/yourfile.extension). Essentially, the server hosting your
                    application also holds and serves the uploaded content.
                </p>
                <p id="s3StorageDetails" style="display: none">
                    <b>AWS S3 (Simple Storage Service):</b> <br>
                    On the other hand, if you opt for AWS S3, all the images, videos, and files you upload are stored in
                    an AWS S3 bucket. AWS S3 is a scalable object storage service provided by Amazon Web Services.
                    Instead of residing on the same server as your application, the files are stored in a separate and
                    dedicated storage infrastructure provided by AWS. Accessing these files is done through the AWS S3
                    endpoint, which is a specific URL provided by AWS for your S3 bucket. This separation allows for
                    scalable and reliable storage, and you can access your files via the AWS S3 endpoint rather than
                    through your application's domain.
                </p>
            </div>

            <div class="col-8 px-5">
                <div class="mb-3">
                    <label for="storageType" class="form-label">Storage Type</label>
                    <select class="form-select @error('storage_type') is-invalid @enderror" name="storage_type"
                            id="storageType">
                        <option value="public" {{old('storage_type') === 'public' ? 'selected' : ''}}>Local - Self Storage</option>
                        <option value="s3" {{old('storage_type') === 's3' ? 'selected' : ''}}>AWS S3</option>
                    </select>
                    @error('storage_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="s3Form" style="display: {{ old('storage_type') === 's3' ? 'block' : 'none'  }}">
                    <div class="mb-3">
                        <label for="region" class="form-label">Region</label>
                        <input type="text" name="s3_region"
                               class="form-control @error('s3_region') is-invalid @enderror" id="region"
                               placeholder="Region">
                        @error('s3_region')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="key" class="form-label">Key</label>
                        <input type="text" name="s3_key" class="form-control @error('s3_key') is-invalid @enderror"
                               id="key" placeholder="Key">
                        @error('s3_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="key" class="form-label">Secret</label>
                        <input type="text" name="s3_secret" class="form-control @error('s3_secret') is-invalid @enderror"
                               id="key" placeholder="Secret">
                        @error('s3_secret')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bucket" class="form-label">Bucket</label>
                        <input type="text" name="s3_bucket"
                               class="form-control @error('s3_bucket') is-invalid @enderror" id="bucket"
                               placeholder="Bucket">
                        @error('s3_bucket')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="awsUrl" class="form-label">AWS URL</label>
                        <input type="url" name="s3_url" class="form-control @error('s3_url') is-invalid @enderror"
                               id="awsUrl" placeholder="AWS URL">
                        @error('s3_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="awsS3Endpoint" class="form-label">AWS S3 ENDPOINT</label>
                        <input type="url" name="s3_endpoint"
                               class="form-control @error('s3_endpoint') is-invalid @enderror" id="awsS3Endpoint"
                               placeholder="AWS S3 ENDPOINT">
                        @error('s3_endpoint')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <x-installer-navigation-buttons/>
        </form>
    </div>


    <script>
        const storageType = document.querySelector('#storageType')
        const s3Form = document.querySelector('#s3Form')
        const localStorageDetails = document.querySelector('#localStorageDetails')
        const s3StorageDetails = document.querySelector('#s3StorageDetails')

        function setStorage() {
            const choice = storageType.value
            if (choice === 's3') {
                s3Form.style.display = 'block'
                s3StorageDetails.style.display = 'block'
                localStorageDetails.style.display = 'none'

            } else {
                s3Form.style.display = 'none'
                s3StorageDetails.style.display = 'none'
                localStorageDetails.style.display = 'block'
            }
        }

        storageType.addEventListener("change", setStorage)
    </script>
@endsection
