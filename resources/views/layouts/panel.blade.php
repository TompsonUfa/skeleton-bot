<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Обязательные метатеги -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="/css/app.css"/>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous"
    />
    <title>Hardcore</title>
</head>
<body>
<main id="top" class="main">
    <div class="container d-lg-flex">
        <nav
            class="navbar navbar-light navbar-custom navbar-expand-xl align-items-start flex-column "
        >
            <div class="d-flex align-items-center">
                <div class="d-lg-none toggle-icon-wrapper">
                    <button
                        class="btn navbar-toggler-humburger-icon ps-0"
                        data-bs-target="#navbar"
                        data-bs-toggle="collapse"
                        aria-expanded="true"
                    >
                                <span class="navbar-toggle-icon">
                                    <span class="toggle-line"></span>
                                </span>
                    </button>
                </div>
                <a class="navbar-brand px-2 py-0" href="/">PANEL</a>
            </div>
            <div class="collapse align-items-start d-lg-block" id="navbar">
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('dashboard') }}"
                            >
                                        <span class="nav-link-icon">
                                            <svg class="svg-inline--fa fa-chart-bar fa-w-16 text-900 fs-3"
                                                 aria-hidden="true" focusable="false" data-prefix="far"
                                                 data-icon="chart-bar" role="img" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor"
                                                                                              d="M396.8 352h22.4c6.4 0 12.8-6.4 12.8-12.8V108.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v230.4c0 6.4 6.4 12.8 12.8 12.8zm-192 0h22.4c6.4 0 12.8-6.4 12.8-12.8V140.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v198.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h22.4c6.4 0 12.8-6.4 12.8-12.8V204.8c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v134.4c0 6.4 6.4 12.8 12.8 12.8zM496 400H48V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zm-387.2-48h22.4c6.4 0 12.8-6.4 12.8-12.8v-70.4c0-6.4-6.4-12.8-12.8-12.8h-22.4c-6.4 0-12.8 6.4-12.8 12.8v70.4c0 6.4 6.4 12.8 12.8 12.8z"></path></svg>
                                        </span>
                                <span class="nav-link-text ps-2 far">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('users') }}">
                                <span class="nav-link-icon">
                                    <svg
                                        class="svg-inline--fa fa-user fa-w-14"
                                        aria-hidden="true"
                                        focusable="false"
                                        data-prefix="fas"
                                        data-icon="user"
                                        role="img"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512"
                                        data-fa-i2svg=""
                                    >
                                        <path fill="currentColor"
                                              d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                                        ></path>
                                    </svg>
                                </span>
                                <span class="nav-link-text ps-2">Users</span>
                            </a>
                        </li>

                        {{--                        <li class="nav-item">--}}
                        {{--                            <a--}}
                        {{--                                class="nav-link d-flex"--}}
                        {{--                                href="{{ route('tasks.index') }}"--}}
                        {{--                            >--}}
                        {{--                                        <span class="nav-link-icon">--}}
                        {{--                                        <svg class="svg-inline--fa fa-tasks fa-w-16 text-900 fs-3" aria-hidden="true"--}}
                        {{--                                             focusable="false" data-prefix="fas" data-icon="tasks" role="img"--}}
                        {{--                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path--}}
                        {{--                                                fill="currentColor"--}}
                        {{--                                                d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path></svg>--}}
                        {{--                                        </span>--}}
                        {{--                                <span class="nav-link-text ps-2">Tasks</span>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}

                        {{--                        <li class="nav-item">--}}
                        {{--                            <a--}}
                        {{--                                class="nav-link d-flex"--}}
                        {{--                                href="{{ route('top') }}"--}}
                        {{--                            >--}}
                        {{--                                                                <span class="nav-link-icon">--}}
                        {{--                                                                    <svg--}}
                        {{--                                                                        class="svg-inline--fa fa-chart-line fa-w-16"--}}
                        {{--                                                                        aria-hidden="true"--}}
                        {{--                                                                        focusable="false"--}}
                        {{--                                                                        data-prefix="fas"--}}
                        {{--                                                                        data-icon="chart-line"--}}
                        {{--                                                                        role="img"--}}
                        {{--                                                                        xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                                                        viewBox="0 0 512 512"--}}
                        {{--                                                                        data-fa-i2svg=""--}}
                        {{--                                                                    >--}}
                        {{--                                                                        <path--}}
                        {{--                                                                            fill="currentColor"--}}
                        {{--                                                                            d="M496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16zM464 96H345.94c-21.38 0-32.09 25.85-16.97 40.97l32.4 32.4L288 242.75l-73.37-73.37c-12.5-12.5-32.76-12.5-45.25 0l-68.69 68.69c-6.25 6.25-6.25 16.38 0 22.63l22.62 22.62c6.25 6.25 16.38 6.25 22.63 0L192 237.25l73.37 73.37c12.5 12.5 32.76 12.5 45.25 0l96-96 32.4 32.4c15.12 15.12 40.97 4.41 40.97-16.97V112c.01-8.84-7.15-16-15.99-16z"--}}
                        {{--                                                                        ></path>--}}
                        {{--                                                                    </svg>--}}
                        {{--                                                                </span>--}}
                        {{--                                <span class="nav-link-text ps-2"--}}
                        {{--                                >Top users</span--}}
                        {{--                                >--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}

                        {{--                        <li class="nav-item">--}}
                        {{--                            <a--}}
                        {{--                                    class="nav-link d-flex"--}}
                        {{--                                    href="{{ route('sends') }}">--}}
                        {{--                                <span class="nav-link-icon">--}}
                        {{--                                    <svg--}}
                        {{--                                            class="svg-inline--fa fa-user fa-w-14"--}}
                        {{--                                            aria-hidden="true"--}}
                        {{--                                            focusable="false"--}}
                        {{--                                            data-prefix="fas"--}}
                        {{--                                            data-icon="user"--}}
                        {{--                                            role="img"--}}
                        {{--                                            xmlns="http://www.w3.org/2000/svg"--}}
                        {{--                                            viewBox="0 0 448 512"--}}
                        {{--                                            data-fa-i2svg=""--}}
                        {{--                                    >--}}
                        {{--                                        <path fill="currentColor"--}}
                        {{--                                              d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"--}}
                        {{--                                        ></path>--}}
                        {{--                                    </svg>--}}
                        {{--                                </span>--}}
                        {{--                                <span class="nav-link-text ps-2">Sends</span>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}

                        {{--                        <li class="nav-item">--}}
                        {{--                            <a--}}
                        {{--                                class="nav-link d-flex"--}}
                        {{--                                href="{{ route('referral') }}"--}}
                        {{--                            >--}}
                        {{--                                        <span class="nav-link-icon">--}}
                        {{--                                           <svg class="svg-inline--fa fa-link fa-w-16 text-900 fs-3" aria-hidden="true"--}}
                        {{--                                                focusable="false" data-prefix="fas" data-icon="link" role="img"--}}
                        {{--                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"--}}
                        {{--                                                data-fa-i2svg=""><path fill="currentColor"--}}
                        {{--                                                                       d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z"></path></svg>--}}
                        {{--                                        </span>--}}
                        {{--                                <span class="nav-link-text ps-2">Referral Links</span>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}
                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('sends') }}">
                                        <span class="nav-link-icon">
                                        <svg
                                            class="svg-inline--fa fa-user fa-w-14"
                                            aria-hidden="true"
                                            focusable="false"
                                            data-prefix="fas"
                                            data-icon="user"
                                            role="img"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512"
                                            data-fa-i2svg=""
                                        >
                                        <path fill="currentColor"
                                              d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"
                                        ></path>
                                    </svg>

                                        </span>
                                <span class="nav-link-text ps-2">Sends</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('seasons') }}"
                            >
                                        <span class="nav-link-icon">
                                            <svg
                                                class="svg-inline--fa fa-poll fa-w-14"
                                                aria-hidden="true"
                                                focusable="false"
                                                data-prefix="fas"
                                                data-icon="poll"
                                                role="img"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 448 512"
                                                data-fa-i2svg=""
                                            >
                                                <path
                                                    fill="currentColor"
                                                    d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM160 368c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16V240c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v128zm96 0c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16V144c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v224zm96 0c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-64c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v64z"
                                                ></path>
                                            </svg>
                                        </span>
                                <span class="nav-link-text ps-2"
                                >Seasons</span
                                >
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('languages') }}">
                                        <span class="nav-link-icon">
<svg class="svg-inline--fa fa-amilia fa-w-14 text-900 fs-3" aria-hidden="true" focusable="false" data-prefix="fab"
     data-icon="amilia" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path
        fill="currentColor"
        d="M240.1 32c-61.9 0-131.5 16.9-184.2 55.4-5.1 3.1-9.1 9.2-7.2 19.4 1.1 5.1 5.1 27.4 10.2 39.6 4.1 10.2 14.2 10.2 20.3 6.1 32.5-22.3 96.5-47.7 152.3-47.7 57.9 0 58.9 28.4 58.9 73.1v38.5C203 227.7 78.2 251 46.7 264.2 11.2 280.5 16.3 357.7 16.3 376s15.2 104 124.9 104c47.8 0 113.7-20.7 153.3-42.1v25.4c0 3 2.1 8.2 6.1 9.1 3.1 1 50.7 2 59.9 2s62.5.3 66.5-.7c4.1-1 5.1-6.1 5.1-9.1V168c-.1-80.3-57.9-136-192-136zm50.2 348c-21.4 13.2-48.7 24.4-79.1 24.4-52.8 0-58.9-33.5-59-44.7 0-12.2-3-42.7 18.3-52.9 24.3-13.2 75.1-29.4 119.8-33.5z"></path></svg>
                                        </span>
                                <span class="nav-link-text ps-2">Languages</span>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a
                                class="nav-link d-flex"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="nav-link-icon">
                                            <svg
                                                class="svg-inline--fa fa-rocket fa-w-16"
                                                aria-hidden="true"
                                                focusable="false"
                                                data-prefix="fas"
                                                data-icon="rocket"
                                                role="img"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 512 512"
                                                data-fa-i2svg="">
                                                <path
                                                    fill="currentColor"
                                                    d="M505.12019,19.09375c-1.18945-5.53125-6.65819-11-12.207-12.1875C460.716,0,435.507,0,410.40747,0,307.17523,0,245.26909,55.20312,199.05238,128H94.83772c-16.34763.01562-35.55658,11.875-42.88664,26.48438L2.51562,253.29688A28.4,28.4,0,0,0,0,264a24.00867,24.00867,0,0,0,24.00582,24H127.81618l-22.47457,22.46875c-11.36521,11.36133-12.99607,32.25781,0,45.25L156.24582,406.625c11.15623,11.1875,32.15619,13.15625,45.27726,0l22.47457-22.46875V488a24.00867,24.00867,0,0,0,24.00581,24,28.55934,28.55934,0,0,0,10.707-2.51562l98.72834-49.39063c14.62888-7.29687,26.50776-26.5,26.50776-42.85937V312.79688c72.59753-46.3125,128.03493-108.40626,128.03493-211.09376C512.07526,76.5,512.07526,51.29688,505.12019,19.09375ZM384.04033,168A40,40,0,1,1,424.05,128,40.02322,40.02322,0,0,1,384.04033,168Z"
                                                ></path>
                                            </svg>
                                        </span>
                                <span class="nav-link-text ps-2">Logout</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <nav class="navbar content-header"></nav>

            <div id="app">
                @yield('content')
            </div>
            <form
                id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none"
            >
                @csrf
            </form>
        </div>
    </div>
</main>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
></script>

<script src="/js/app.js"></script>
</body>
</html>
