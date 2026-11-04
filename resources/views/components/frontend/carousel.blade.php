<section class="w-full px-4 sm:px-6 lg:px-10 xl:px-12 2xl:px-16 py-6 sm:py-8">
    <div
        class="relative w-full h-100 sm:h-125 md:h-150 lg:h-162.5 overflow-hidden rounded-2xl shadow-2xl bg-slate-900 group">

        <div id="carousel-track" class="relative w-full h-full">

            <!-- slide 1 -->
            <div class="carousel-slide absolute inset-0 transition-opacity duration-700">
                <img src="{{ asset('assets/images/carousel/carousel1.jpg') }}" alt="Team"
                    class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-1000">
                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute inset-x-0 bottom-6 sm:bottom-10 md:bottom-16 flex justify-center px-4 sm:px-6">
                    <div
                        class="max-w-3xl w-full backdrop-blur-md bg-white/5 border border-white/20 p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl text-center shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                        <p class="mb-3 sm:mb-4 text-xs sm:text-sm font-bold tracking-widest uppercase text-amber">
                            Academic Excellence &middot; NCTB Curriculum
                        </p>
                        <h1
                            class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-3 sm:mb-4 tracking-tight">
                            Plan, learn, and <span class="text-amber">succeed together</span>
                        </h1>
                        <p
                            class="text-slate-200 text-sm sm:text-base md:text-lg mb-5 sm:mb-8 max-w-xl mx-auto leading-relaxed">
                            A unified school management and academic portal connecting educators, students, and
                            guardians.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                            <a href="{{ route('dashboard') }}"
                                class="px-6 sm:px-8 py-3 sm:py-4 bg-amber hover:bg-white text-ink font-bold rounded-xl sm:rounded-2xl transition-all duration-300 shadow-lg hover:shadow-amber/20 transform hover:-translate-y-1 text-sm sm:text-base">
                                Open Dashboard
                            </a>
                            <a href="#contact"
                                class="px-6 sm:px-8 py-3 sm:py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl sm:rounded-2xl border border-white/25 transition-all duration-300 text-sm sm:text-base">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- slide 2 -->
            <div class="carousel-slide absolute inset-0 transition-opacity duration-700">
                <img src="{{ asset('assets/images/carousel/carousel2.jpg') }}" alt="Team"
                    class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-1000">
                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute inset-x-0 bottom-6 sm:bottom-10 md:bottom-16 flex justify-center px-4 sm:px-6">
                    <div
                        class="max-w-3xl w-full backdrop-blur-md bg-white/5 border border-white/20 p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl text-center shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                        <p class="mb-3 sm:mb-4 text-xs sm:text-sm font-bold tracking-widest uppercase text-amber">
                            Automated NCTB Grading &middot; Merit Tabulation
                        </p>
                        <h1
                            class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-3 sm:mb-4 tracking-tight">
                            Smart digital <span class="text-amber">result management</span>
                        </h1>
                        <p
                            class="text-slate-200 text-sm sm:text-base md:text-lg mb-5 sm:mb-8 max-w-xl mx-auto leading-relaxed">
                            Instant GPA calculation, combined paper evaluation, and automated class merit rankings.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                            <a href="/exam-results"
                                class="px-6 sm:px-8 py-3 sm:py-4 bg-amber hover:bg-white text-ink font-bold rounded-xl sm:rounded-2xl transition-all duration-300 shadow-lg hover:shadow-amber/20 transform hover:-translate-y-1 text-sm sm:text-base">
                                View Merit Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- slide 3 -->
            <div class="carousel-slide absolute inset-0 transition-opacity duration-700">
                <img src="{{ asset('assets/images/carousel/carousel3.jpg') }}" alt="Team"
                    class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-1000">
                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute inset-x-0 bottom-6 sm:bottom-10 md:bottom-16 flex justify-center px-4 sm:px-6">
                    <div
                        class="max-w-3xl w-full backdrop-blur-md bg-white/5 border border-white/20 p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl text-center shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                        <p class="mb-3 sm:mb-4 text-xs sm:text-sm font-bold tracking-widest uppercase text-amber">
                            Student Directory &middot; Online Admission
                        </p>
                        <h1
                            class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-3 sm:mb-4 tracking-tight">
                            Empowering every <span class="text-amber">student's journey</span>
                        </h1>
                        <p
                            class="text-slate-200 text-sm sm:text-base md:text-lg mb-5 sm:mb-8 max-w-xl mx-auto leading-relaxed">
                            Streamlined student enrollment, class section organization, and role-based user access.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                            <a href="/students"
                                class="px-6 sm:px-8 py-3 sm:py-4 bg-amber hover:bg-white text-ink font-bold rounded-xl sm:rounded-2xl transition-all duration-300 shadow-lg hover:shadow-amber/20 transform hover:-translate-y-1 text-sm sm:text-base">
                                Student Directory
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <button id="prev-btn"
            class="absolute left-3 sm:left-4 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/10 hover:bg-amber backdrop-blur-md flex items-center justify-center text-white hover:text-ink transition-all duration-300 z-20 border border-white/10">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5"
                viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
        <button id="next-btn"
            class="absolute right-3 sm:right-4 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/10 hover:bg-amber backdrop-blur-md flex items-center justify-center text-white hover:text-ink transition-all duration-300 z-20 border border-white/10">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5"
                viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>

        <!-- Pagination Dots -->
        <div id="dots"
            class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-2 sm:gap-3 z-20 px-3 sm:px-4 py-1.5 sm:py-2 bg-black/20 backdrop-blur-sm rounded-full">
        </div>
    </div>
</section>
