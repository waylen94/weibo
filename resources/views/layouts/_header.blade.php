<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
<!--   <div class="container "> -->
<!--     <a class="navbar-brand" href="/">Weibo App</a> -->
<!--     <ul class="navbar-nav justify-content-end"> -->
<!--       <li class="nav-item"><a class="nav-link" href="{{route('help')}}">help</a></li> -->
<!--       <li class="nav-item" ><a class="nav-link" href="{{route('help')}}">login</a></li> -->
<!--     </ul> -->
<!--   </div> -->
<!-- </nav> -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container ">
    <a class="navbar-brand" href="{{ route('home') }}">Weibo App</a>
    <ul class="navbar-nav justify-content-end">
      @if (Auth::check())
        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">User List</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">personnel</a>
            <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">Modify</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-block btn-danger" type="submit" name="button">Quit</button>
              </form>
            </a>
          </div>
        </li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">Help</a></li>
        <li class="nav-item" ><a class="nav-link" href="{{ route('login') }}">Login</a></li>
      @endif
    </ul>
  </div>
</nav>