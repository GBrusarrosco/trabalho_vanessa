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

                        {{-- Links para Formulários e Perguntas --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador', 'professor']))
                            <x-nav-link :href="route('forms.index')" :active="request()->routeIs('forms.*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('forms.*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Formulários') }}
                            </x-nav-link>
                            <x-nav-link :href="route('questions.index')" :active="request()->routeIs('questions.*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('questions.*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Perguntas') }}
                            </x-nav-link>
                        @endif

                        {{-- Links apenas para Admin e Coordenador --}}
                        @if(in_array(Auth::user()->role, ['admin', 'coordenador']))
                            <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('teachers.*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Professores') }}
                            </x-nav-link>
                            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')"
                                        class="text-paragraph hover:text-primary focus:text-primary {{ request()->routeIs('students.*') ? 'border-primary' : 'border-transparent hover:border-secondary focus:border-secondary' }}">
                                {{ __('Alunos') }}
                            </x-nav-link>
                            {{-- LINK REMOVIDO: O link para 'student-form.index' estava aqui --}}
                        @endif

                        {{-- Link de Relatórios --}}
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
                    {{-- ... (código do dropdown do usuário permanece o mesmo) ... --}}
                </div>
            @endauth

            <div class="-me-2 flex items-center sm:hidden">
                {{-- ... (código do menu hamburger permanece o mesmo) ... --}}
            </div>
        </div>
    </div>

    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            {{-- ... (O mesmo link para 'student-form.index' deve ser removido daqui também) ... --}}
        </div>
    @endauth
</nav>
