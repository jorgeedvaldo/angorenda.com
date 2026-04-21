<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar - Angorenda</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' } },
                },
            },
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}" class="flex justify-center flex-col items-center gap-2 text-2xl font-bold text-gray-900 hover:text-brand-600 transition-colors">
            <svg class="w-10 h-10 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Angorenda
        </a>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Aceder à sua conta
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Ou <a href="/signup" class="font-medium text-brand-600 hover:text-brand-500">crie uma conta de proprietário</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-100 sm:rounded-2xl sm:px-10">
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="ml-3">
                            <ul class="text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Palavra-passe</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Manter sessão iniciada
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        Entrar na área reservada
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</body>
</html>
