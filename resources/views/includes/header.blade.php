<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
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
    </script>
@endpush