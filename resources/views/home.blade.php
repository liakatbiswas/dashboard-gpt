<x-guest-layout title="Student's Hub">

    <x-frontend.carousel />

    {{-- ===== HERO ===== --}}
    <section class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div
            class="grid w-full items-center gap-10 px-4 py-16 sm:px-6 md:grid-cols-2 md:gap-14 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">

            <div class="order-2 text-center md:order-1 md:text-left">
                <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                    Educator &middot; Mentor &middot; Lifelong Learner
                </p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Hi, I'm <span class="text-indigo-600 dark:text-indigo-400">Liakat Biswas</span>
                </h1>
                <p
                    class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-300 sm:text-lg md:mx-0">
                    A passionate teacher with 10+ years of experience helping students build confidence,
                    curiosity and strong foundations in Mathematics and Science.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3 md:justify-start">
                    <a href="{{ route(auth()->check() && auth()->user()->cannot('dashboard.view') ? 'account.pending' : 'dashboard') }}"
                        class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-700">
                        {{ auth()->check() && auth()->user()->cannot('dashboard.view') ? 'Go to my account' : 'Go to Dashboard' }}
                    </a>
                    <a href="#contact"
                        class="rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                        Get in touch
                    </a>
                    <a href="#experience"
                        class="rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                        View experience
                    </a>
                </div>
            </div>

            <div class="order-1 flex justify-center md:order-2 md:justify-end">
                <div class="relative">
                    <div class="absolute -inset-4 rounded-4xl bg-indigo-500/20 blur-2xl"></div>
                    <img src="{{ asset('assets/images/no_image.jpg') }}" alt="Teacher portrait"
                        class="relative h-64 w-64 rounded-3xl bg-gray-200 object-cover shadow-xl dark:bg-gray-800 sm:h-80 sm:w-80 lg:h-96 lg:w-96">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATS ===== --}}
    <section class="border-b border-gray-200 dark:border-gray-800">
        <dl
            class="grid w-full grid-cols-2 gap-x-6 gap-y-8 px-4 py-12 text-center sm:px-6 md:grid-cols-4 lg:px-10 xl:px-12 2xl:px-16">
            @foreach ([['10+', 'Years of teaching'], ['1,500+', 'Students taught'], ['25', 'Awards & recognitions'], ['98%', 'Student pass rate']] as [$value, $label])
                <div>
                    <dt class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 sm:text-4xl">{{ $value }}
                    </dt>
                    <dd class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $label }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- ===== ABOUT + PHILOSOPHY ===== --}}
    <section id="about" class="scroll-mt-16">
        <div class="w-full px-4 py-16 sm:px-6 sm:py-20 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">
            <div class="grid gap-10 md:grid-cols-2 lg:gap-14">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                        Who I am</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">About me</h2>
                    <p class="mt-5 leading-relaxed text-gray-600 dark:text-gray-300">
                        I believe every student can learn when lessons are clear, relevant and kind. My classroom
                        blends structured instruction with hands-on activities, group discussion and regular
                        feedback, so learners understand the "why" and not just the "how".
                    </p>
                    <p class="mt-4 leading-relaxed text-gray-600 dark:text-gray-300">
                        Outside the classroom I mentor new teachers, run after-school study clubs and design
                        open learning resources for my community.
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-8">
                    <h3 class="text-lg font-semibold">Teaching philosophy</h3>
                    <ul class="mt-5 space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        @foreach (['Learning starts with curiosity and safety.', 'Assess to understand, not only to grade.', 'Technology should serve the lesson, not replace it.', 'Every student deserves to be seen and heard.'] as $point)
                            <li class="flex items-start gap-3">
                                <i
                                    class="mgc_check_circle_line shrink-0 text-lg leading-5 text-indigo-600 dark:text-indigo-400"></i>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== SUBJECTS / SKILLS ===== --}}
    <section class="border-y border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="w-full px-4 py-16 sm:px-6 sm:py-20 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">
            <div class="mb-10">
                <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">What
                    I teach</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Subjects & skills</h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                @foreach ([['Mathematics', 'Algebra, geometry and problem-solving for grades 6–10.'], ['General Science', 'Inquiry-based lessons with simple, low-cost experiments.'], ['Curriculum design', 'Lesson plans, rubrics and aligned assessments.'], ['Classroom management', 'Positive discipline and inclusive routines.'], ['EdTech', 'Google Classroom, interactive quizzes and blended learning.'], ['Mentoring', 'Coaching early-career teachers and student leaders.']] as [$name, $desc])
                    <div
                        class="rounded-xl border border-gray-200 p-6 transition-shadow hover:shadow-md dark:border-gray-800">
                        <h3 class="font-semibold">{{ $name }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== EXPERIENCE TIMELINE ===== --}}
    <section id="experience" class="scroll-mt-16">
        <div class="w-full px-4 py-16 sm:px-6 sm:py-20 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">
            <div class="mb-10">
                <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">My
                    journey</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Experience</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([['2020 – Present', 'Senior Teacher, Mathematics', 'Sunrise High School', 'Lead the maths department, mentor 6 teachers and raised board exam results by 18%.'], ['2016 – 2020', 'Science Teacher', 'Greenfield Academy', 'Introduced a weekly science fair and a student robotics club.'], ['2013 – 2016', 'Assistant Teacher', 'City Model School', 'Taught grades 6–8 and coordinated the annual cultural program.']] as [$period, $role, $place, $summary])
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-400">
                            {{ $period }}</p>
                        <h3 class="mt-2 font-semibold text-base">{{ $role }} &middot; {{ $place }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $summary }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== EDUCATION & CERTIFICATIONS ===== --}}
    <section class="border-y border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div
            class="grid w-full gap-12 px-4 py-16 sm:px-6 sm:py-20 md:grid-cols-2 lg:gap-14 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">
            <div>
                <h2 class="text-2xl font-bold sm:text-3xl">Education</h2>
                <ul class="mt-8 space-y-6 text-sm">
                    <li>
                        <p class="font-semibold">M.Ed., Curriculum & Instruction</p>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">University of Dhaka &middot; 2015</p>
                    </li>
                    <li>
                        <p class="font-semibold">B.Sc. in Mathematics</p>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">National University &middot; 2012</p>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="text-2xl font-bold sm:text-3xl">Certifications & awards</h2>
                <ul class="mt-8 space-y-6 text-sm">
                    <li>
                        <p class="font-semibold">Best Teacher Award</p>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">Sunrise High School &middot; 2023</p>
                    </li>
                    <li>
                        <p class="font-semibold">Google Certified Educator (Level 2)</p>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">Google for Education &middot; 2022</p>
                    </li>
                    <li>
                        <p class="font-semibold">Differentiated Instruction Workshop</p>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">Teachers' Training Institute &middot; 2019</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section>
        <div class="w-full px-4 py-16 sm:px-6 sm:py-20 lg:px-10 lg:py-24 xl:px-12 2xl:px-16">
            <div class="mb-10">
                <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Kind
                    words</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">What others say</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([['Maths finally makes sense! Every class felt like a conversation, not a lecture.', 'Student, Grade 10'], ['A dedicated teacher who goes the extra mile for every child.', 'Parent'], ['An inspiring mentor for our newer staff members.', 'Headmaster']] as [$quote, $author])
                    <figure
                        class="flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <blockquote class="text-sm italic leading-relaxed text-gray-700 dark:text-gray-300">
                            “{{ $quote }}”</blockquote>
                        <figcaption class="mt-6 text-xs font-semibold text-indigo-600 dark:text-indigo-400">—
                            {{ $author }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CONTACT CTA ===== --}}
    <section id="contact" class="scroll-mt-16">
        <div class="w-full px-4 pb-16 sm:px-6 sm:pb-20 lg:px-10 lg:pb-24 xl:px-12 2xl:px-16">
            <div class="rounded-3xl bg-indigo-600 px-6 py-12 text-center text-white shadow-lg sm:px-12 sm:py-16">
                <h2 class="text-2xl font-bold sm:text-3xl">Let's work together</h2>
                <p class="mx-auto mt-4 max-w-xl text-indigo-100">
                    Available for teaching positions, tutoring, workshops and curriculum consulting.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3 text-sm font-medium">
                    <a href="mailto:liakatbiswas@gmail.com"
                        class="rounded-lg bg-white px-6 py-3 text-indigo-700 transition-colors hover:bg-indigo-50">
                        liakatbiswas@gmail.com
                    </a>
                    <a href="tel:01571-719052"
                        class="rounded-lg border border-white/40 px-6 py-3 transition-colors hover:bg-white/10">
                        01571-719052
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
