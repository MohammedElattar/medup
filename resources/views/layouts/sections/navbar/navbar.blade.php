@php
  $containerNav = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
  $navbarDetached = ($navbarDetached ?? '');
  $user = auth()->user();
  $user->load('avatar');
@endphp

  <!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
  <nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
    @endif
    @if(isset($navbarDetached) && $navbarDetached == '')
      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{$containerNav}}">
          @endif
          @if(isset($navbarFull))
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
              <a href="{{url('/')}}" class="app-brand-link">
                <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
                <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}}</span>
              </a>
              @if(isset($menuHorizontal))
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                  <i class="ti ti-x ti-md align-middle"></i>
                </a>
              @endif
            </div>
          @endif

          <!-- ! Not required for layout-without-menu -->
          @if(!isset($navbarHideToggle))
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-md"></i>
              </a>
            </div>
          @endif

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- Language -->
              <li class="nav-item dropdown-language dropdown">
                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <i class='ti ti-language rounded-circle ti-md'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  @foreach(\App\Helpers\TranslationHelper::getAvailableLocales() as $locale)
                    <li>
                      <a
                        class="dropdown-item
                        {{ \App\Helpers\TranslationHelper::getCurrentLocale() === $locale ? 'active' : '' }}"
                        data-language="{{$locale}}"
                        href="{{route('change-locale', $locale)}}"
                        data-text-direction="{{$locale == 'ar' ? 'rtl' : 'ltr'}}"
                      >
                        <span>{{translate_ui($locale)}}</span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </li>
              <!-- / Language -->
              @if($configData['hasCustomizer'] == true)
                <li class="nav-item dropdown-style-switcher dropdown">
                  <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='ti ti-md'></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                        <span class="align-middle"><i class='ti ti-sun ti-md me-3'></i>{{translate_ui('light')}}</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                        <span class="align-middle"><i class="ti ti-moon-stars ti-md me-3"></i>{{translate_ui('dark')}}</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                        <span class="align-middle"><i class="ti ti-device-desktop-analytics ti-md me-3"></i>{{translate_ui('system_light')}}</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- / Style Switcher -->
              @endif

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown ms-2">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img
                      src="{{\App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($user, 'avatar', 'user.png')}}"
                      alt
                      class="rounded-circle">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item mt-0" href="{{route('profile.show')}}">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                          <div class="avatar avatar-online">
                            <img
                              src="{{\App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($user, 'avatar', 'user.png')}}"
                              alt class="rounded-circle">
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="mb-0">
                            {{ Auth::user()->name }}
                          </h6>
                          <small class="text-muted">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1 mx-n2"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('profile.show')}}">
                      <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">{{translate_ui('profile')}}</span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1 mx-n2"></div>
                  </li>
                  @if (Auth::check())
                    <li>
                      <div class="d-grid px-2 pt-2 pb-1">
                        <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <small class="align-middle">{{translate_ui('logout')}}</small>
                          <i class="ti ti-logout ms-2 ti-14px"></i>
                        </a>
                      </div>
                    </li>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                      @csrf
                    </form>
                  @endif
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
          @if(isset($navbarDetached) && $navbarDetached == '')
        </div>
        @endif
      </nav>
