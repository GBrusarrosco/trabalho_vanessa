<nav x-data="{ open: false }" class="bg-background border-b border-secondary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="text-2xl font-bold text-primary tracking-tight select-none hover:text-opacity-80 transition">
                            Avaliação Institucional
                        </span>
                    </a>
                </div>

                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                    class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('dashboard') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                            {{ __('Painel') }}
                        </x-nav-link>

                        {{-- Links para Admin, Coordenador e Professor --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                            <x-nav-link :href="route('forms.index')" :active="request()->routeIs('forms.index') || request()->routeIs('forms.create') || request()->routeIs('forms.edit')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ (request()->routeIs('forms.index') || request()->routeIs('forms.create') || request()->routeIs('forms.edit')) ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Formulários') }}
                            </x-nav-link>
                            <x-nav-link :href="route('questions.index')" :active="request()->routeIs('questions.index') || request()->routeIs('questions.create') || request()->routeIs('questions.edit')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ (request()->routeIs('questions.index') || request()->routeIs('questions.create') || request()->routeIs('questions.edit')) ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Perguntas') }}
                            </x-nav-link>
                        @endif

                        {{-- Links apenas para Admin e Coordenador --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador']))
                            <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.index*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('teachers.index*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Professores') }}
                            </x-nav-link>
                            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.index*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('students.index*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Alunos') }}
                            </x-nav-link>
                            <x-nav-link :href="route('student-form.index')" :active="request()->routeIs('student-form.index*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('student-form.index*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Associar Alunos') }}
                            </x-nav-link>
                        @endif

                        {{-- Link de Relatórios para Admin, Coordenador e Professor --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                            <x-nav-link :href="route('report.index')" :active="request()->routeIs('report.index')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('report.index') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Relatórios') }}
                            </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>

            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-paragraph bg-background hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-paragraph hover:bg-secondary hover:text-primary">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="text-paragraph hover:bg-secondary hover:text-primary">
                                    {{ __('Sair') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-paragraph hover:text-primary hover:bg-secondary focus:outline-none focus:bg-secondary focus:text-primary transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                       class="text-paragraph {{ request()->routeIs('dashboard') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                    {{ __('Painel') }}
                </x-responsive-nav-link>

                @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                    <x-responsive-nav-link :href="route('forms.index')" :active="request()->routeIs('forms.index*')" class="text-paragraph {{ request()->routeIs('forms.index*') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Formulários') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('questions.index')" :active="request()->routeIs('questions.index*')" class="text-paragraph {{ request()->routeIs('questions.index*') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Perguntas') }}
                    </x-responsive-nav-link>
                @endif

                @if(in_array(Auth::user()->role, ['admin', 'coordenador']))
                    <x-responsive-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.index*')" class="text-paragraph {{ request()->routeIs('teachers.index*') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Professores') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.index*')" class="text-paragraph {{ request()->routeIs('students.index*') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Alunos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('student-form.index')" :active="request()->routeIs('student-form.index*')" class="text-paragraph {{ request()->routeIs('student-form.index*') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Associar Alunos') }}
                    </x-responsive-nav-link>
                @endif

                @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                    <x-responsive-nav-link :href="route('report.index')" :active="request()->routeIs('report.index')" class="text-paragraph {{ request()->routeIs('report.index') ? 'bg-secondary border-primary text-primary' : 'border-transparent hover:bg-gray-50 hover:border-gray-300' }} focus:text-primary focus:border-primary">
                        {{ __('Relatórios') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            {{-- Restante do menu responsivo (perfil, logout) permanece o mesmo --}}
            <div class="pt-4 pb-1 border-t border-secondary">
                <div class="px-4">
                    <div class="font-medium text-base text-headline">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-paragraph">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-paragraph hover:text-primary hover:bg-secondary focus:bg-secondary">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="text-paragraph hover:text-primary hover:bg-secondary focus:bg-secondary">
                            {{ __('Sair') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>
