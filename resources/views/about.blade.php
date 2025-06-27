@extends('layouts.app')

@section('title', 'About - QuickForms')

@section('content')
    <!-- Hero Section -->
    <div class="relative pt-24 pb-16 sm:pt-32 sm:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">About</span>
                    <span class="block text-indigo-600">QuickForms</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    We're on a mission to simplify form creation and data collection for everyone.
                </p>
            </div>
        </div>
    </div>

    <!-- Our Story -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Our Story</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Empowering Users Through Simple Solutions
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    QuickForms was born from a simple idea: making form creation accessible to everyone, regardless of technical expertise.
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Our Mission</h3>
                            <p class="mt-2 text-base text-gray-500">
                                To empower individuals and organizations to create effective forms and collect valuable data without the need for technical expertise.
                            </p>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Our Values</h3>
                            <p class="mt-2 text-base text-gray-500">
                                We believe in simplicity, reliability, and putting our users first. Every feature we build is designed with these principles in mind.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to get started?</span>
                <span class="block text-indigo-200">Join thousands of satisfied users today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Get started
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Our Team</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Meet the People Behind QuickForms
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-x-8 md:gap-y-10">
                    <!-- Team Member 1 -->
                    <div class="text-center">
                        <div class="flex justify-center">
                            
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">Filip Pietruszka</h3>
                            <p class="text-sm text-gray-500">Backend Developer</p>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="text-center">
                        <div class="flex justify-center">
                         
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">Nigel Bescholtz</h3>
                            <p class="text-sm text-gray-500">Backend Developer</p>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="text-center">
                        <div class="flex justify-center">
                            
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">Sam Varkevisser</h3>
                            <p class="text-sm text-gray-500">Desigener & Frontend Developer</p>
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="text-center">
                        <div class="flex justify-center">
                          
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">Noah Stortenbeker</h3>
                            <p class="text-sm text-gray-500">UX Designer & Frontend Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 