<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    <!-- Auto-refresh every 10 seconds to check status -->
    <meta http-equiv="refresh" content="10">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg text-center">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Account Status: Pending Approval</h2>
    <p class="text-gray-700 mb-6">
        Thank you for registering! Your account is currently awaiting approval from an administrator.
        Please wait for your account to be approved. This page will automatically refresh to check your status.
    </p>
    <p class="text-gray-600 text-sm mb-4">
        Current status: <span class="font-semibold text-orange-500"><?= esc($userStatus) ?></span>
    </p>
    <p class="text-gray-600 text-sm">
        You will be redirected to your dashboard once approved.
    </p>
    <div class="mt-8">
        <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
            Logout
        </a>
    </div>
</div>
</body>
</html>