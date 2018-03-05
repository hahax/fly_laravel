<div class="container">
    <div class="preview-image-box">
        <div class="inside-image-box">
            <img class="uploaded-image" src="asset('storage/avatars')" alt="">
        </div>
        <div class="loading-shadow">
            <div class="loading-icon">
                <img src="http://www.muyesanren.com/loading.gif" alt="">
            </div>
        </div>
    </div>
    <div class="js-reset-image">
        <span class="upload-text on">上传</span>
        <span class="re-upload-text">重新上传</span>
    </div>
    <form id="uploadForm" action="/user/uploadImg" method="post">
        {{ csrf_field() }}
    <input style="display: none;" name="image" type="file" class="inputFile" />
    </form>
</div>
@include('layouts.layup')

@section('js')
    @include("layouts.js")
@endsection
