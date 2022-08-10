<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        @if(auth()->user()->role == "Admin")
        <li class="nav-item">
            <a class="nav-link" role="button" onclick="openThemes()">
                <i class="fa-solid fa-gear">
                    Themes
                </i>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <a class="nav-link" role="button" onclick="logout()">
                    <i class="fa-solid fa-right-from-bracket">
                        Sign Out
                    </i>
                </a>
            </form>
        </li>
    </ul>
</nav>

@push('scripts')
    <script>
        function logout(){
            $('#logoutForm').submit();
        }

        function openThemes(){
            Swal.fire({
                width: '600px',
                html: `
                    @foreach($theme as $key => $team)
                        <div class="row">
                            <div class="col-md-5">
                                {{ ucwords(implode(' ', explode('_', $key))) }}
                            </div>
                            <div class="col-md-7">

                        @if(str_contains($key, 'img'))
                            <img src="{{ $team }}" id="{{ $key }}" alt="{{ $key }}" width="100px;" height="100px">
                            <br>
                            <br>
                            ${input('{{ $key }}', '', '{{ $team }}', 0, 10, 'file')}
                        @elseif(str_contains($key, 'color'))
                            ${input('{{ $key }}', '', '{{ $team }}', 0, 12, 'color')}
                        @else
                            ${input('{{ $key }}', '', '{{ $team }}', 0, 12)}
                        @endif

                            </div>
                        </div>
                        <br>
                    @endforeach
                `,
                didOpen: () => {
                    $('.swal2-container .col-md-5').css({
                        'text-align': 'left',
                        'margin': 'auto'
                    });
                    $('.swal2-container .col-md-7 div').css({
                        'text-align': 'center',
                        'margin': 'auto'
                    });

                    $('[type="file"]').on('change', e => {
                        var reader = new FileReader();
                        reader.onload = function (e2) {
                            let name = $(e.target).prop('name');
                            $(`#${name}`).attr('src', e2.target.result);
                        }

                        reader.readAsDataURL(e.target.files[0]); 
                    });
                }
            }).then(result => {
                if(result.value){
                    swal.showLoading();

                    let formData = new FormData();
                    formData.append('app_name', $('[name="app_name"]').val());
                    formData.append('logo_img', $('[name="logo_img"]').prop('files')[0]);
                    formData.append('login_banner_img', $('[name="login_banner_img"]').prop('files')[0]);
                    formData.append('login_bg_img', $('[name="login_bg_img"]').prop('files')[0]);
                    formData.append('sidebar_bg_color', $('[name="sidebar_bg_color"]').val());
                    formData.append('table_header_color', $('[name="table_header_color"]').val());
                    formData.append('table_header_font_color', $('[name="table_header_font_color"]').val());
                    formData.append('sidebar_font_color', $('[name="sidebar_font_color"]').val());
                    formData.append('table_group_color', $('[name="table_group_color"]').val());
                    formData.append('table_group_font_color', $('[name="table_group_font_color"]').val());
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    updateTheme(formData);
                }
            })
        }

        async function updateTheme(formData){
            await fetch('{{ route('theme.update') }}', {
                method: "POST", 
                body: formData,
            }).then(result => {
                console.log(result);
                ss("Successfully Updated Theme", "Refreshing");
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            });
        }
    </script>
@endpush