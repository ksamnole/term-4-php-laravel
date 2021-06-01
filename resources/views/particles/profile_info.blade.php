<div class="profile_info">
    <img class="profile_img" src="{{ url('imgs/default_photo_profile.jpg') }}" alt="profile_img">
    <br>
    <h2 style="text-align: center;">{{ $user->getUsername() }}</h2>
    <br>
    @if (Auth::user()->isAdmin() || Auth::user()->getUsername() == $user->getUsername())
        <p style="text-align: center;"><a class="delete-profile" id="delete" onclick="_delete()" href="#">Удалить страницу</a></p>
    @endif
    <script>
        function _delete() {
            let del = document.getElementById('delete');
            if (del.textContent == 'Уверен?') {
                del.setAttribute('href', '/profile/delete-page?name={{$user->getUsername()}}')
            }
            del.textContent = 'Уверен?';
        }
    </script>
</div>
