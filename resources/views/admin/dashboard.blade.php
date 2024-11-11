<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Header -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('images/jci-damascus-logo.png') }}" alt="JCI Damascus Logo" class="h-10 mr-4">
            <h1 class="text-xl font-semibold text-blue-800">Admin Dashboard</h1>
        </div>
        <div>
            <span class="text-gray-600">Welcome, Admin</span>
            <a href="{{ route('logout') }}" class="text-blue-600 hover:text-blue-800 ml-4">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Top Voted Candidates Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">Top Voted Candidates</h2>
                <ul>
                    <li class="text-gray-700">Candidate 1 - <span class="font-bold">120 votes</span></li>
                    <li class="text-gray-700">Candidate 2 - <span class="font-bold">95 votes</span></li>
                    <li class="text-gray-700">Candidate 3 - <span class="font-bold">80 votes</span></li>
                    <!-- Add more candidates as needed -->
                </ul>
            </div>

            <!-- Projects Per Category Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">Projects per Category</h2>
                <ul>
                    <li class="text-gray-700">Category A - <span class="font-bold">15 projects</span></li>
                    <li class="text-gray-700">Category B - <span class="font-bold">10 projects</span></li>
                    <li class="text-gray-700">Category C - <span class="font-bold">5 projects</span></li>
                    <!-- Add more categories as needed -->
                </ul>
            </div>

            <!-- Top Voted Project Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">Top Voted Project</h2>
                <p class="text-gray-700">Project Name</p>
                <p class="text-gray-500 text-sm">Description of the top voted project goes here.</p>
                <p class="font-bold text-blue-800 mt-2">Votes: 200</p>
            </div>

            <!-- Active Users Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">Number of Active Users</h2>
                <p class="text-4xl font-bold text-blue-800">125</p>
            </div>
        </div>
    </main>

</body>
</html>
