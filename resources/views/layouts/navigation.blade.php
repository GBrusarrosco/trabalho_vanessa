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
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Painel') }}
                        </x-nav-link>

                        {{-- Formulários e Perguntas (Professor pode ver) --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                            <x-nav-link :href="route('forms.index')" :active="request()->routeIs('forms.*')">
                                {{ __('Formulários') }}
                            </x-nav-link>
                            <x-nav-link :href="route('questions.index')" :active="request()->routeIs('questions.*')">
                                {{ __('Perguntas') }}
                            </x-nav-link>
                        @endif

                        {{-- ===== INÍCIO DA ALTERAÇÃO ===== --}}
                        {{-- Professores (Apenas Admin/Coordenador) --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador']))
                            <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.*')">
                                {{ __('Professores') }}
                            </x-nav-link>
                        @endif

                        {{-- Alunos (Admin/Coordenador/Professor) --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                                {{ __('Alunos') }}
                            </x-nav-link>
                        @endif
                        {{-- ===== FIM DA ALTERAÇÃO ===== --}}

                        {{-- Relatórios --}}
                        @can('view-reports')
                            <x-nav-link :href="route('report.index')" :active="request()->routeIs('report.index')">
                                {{ __('Relatórios') }}
                            </x-nav-link>
                        @endcan
                    </div>
                @endauth
            </div>

            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-headline bg-background hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
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
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Painel') }}
                </x-responsive-nav-link>
                {{-- Adicione outros links aqui para o menu mobile, seguindo a mesma lógica acima --}}
            </div>

            <div class="pt-4 pb-1 border-t border-secondary">
                <div class="px-4">
                    <div class="font-medium text-base text-headline">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-paragraph">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Sair') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>
