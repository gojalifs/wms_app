<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('wms.users.title') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('temp_password'))
                <div class="mb-4 px-4 py-4 bg-yellow-50 border border-yellow-300 text-yellow-900 rounded">
                    <p class="font-semibold mb-1">{{ __('wms.users.temp_password_notice_title') }}</p>
                    <p>{{ __('wms.users.temp_password_notice', ['name' => session('temp_user'), 'password' => session('temp_password')]) }}
                    </p>
                    <p class="mt-1 text-sm text-yellow-700">{{ __('wms.users.temp_password_warning') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($users->isEmpty())
                        <p class="text-gray-500">{{ __('wms.users.no_data') }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">{{ __('wms.users.name') }}
                                    </th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">{{ __('wms.users.email') }}
                                    </th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">{{ __('wms.users.role') }}
                                    </th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">{{ __('wms.users.status') }}
                                    </th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-800">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $user->isAdmin() ? __('wms.users.role_admin') : __('wms.users.role_user') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($user->must_change_password)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ __('wms.users.must_change_password') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            @if ($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                    onsubmit="return confirm('{{ __('wms.users.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        {{ __('wms.general.delete') }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">{{ __('wms.users.you') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center ml-4 mt-4 px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        {{ __('wms.users.add') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>