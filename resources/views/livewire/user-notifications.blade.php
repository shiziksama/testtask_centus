<div class="px-4 py-2">
    <h2 class="text-xl font-bold mb-4">User Notifications</h2>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
        <tr>
            <th class="py-2 px-4 border-b">City Name</th>
            <th class="py-2 px-4 border-b">Probability of Precipitation</th>
            <th class="py-2 px-4 border-b">UV Index</th>
            <th class="py-2 px-4 border-b">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($notifications as $id=>$notification)
            <tr>
                <td class="py-2 px-4 border-b">
                    <input type="text" wire:model.defer="notifications.{{ $id }}.city" value=""
                           class="w-full border rounded px-2 py-1">
                    @error("notifications.$id.city")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td class="py-2 px-4 border-b">
                    <input type="text" wire:model.defer="notifications.{{ $id }}.pop" value=""
                           class="w-full border rounded px-2 py-1">
                    @error("notifications.$id.pop")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td class="py-2 px-4 border-b">
                    <input type="text" wire:model.defer="notifications.{{ $id }}.uvi" value=""
                           class="w-full border rounded px-2 py-1">
                    @error("notifications.$id.uvi")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </td>
                <td class="py-2 px-4 border-b">
                    <button wire:click="updateNotification({{ $notification[
                            'id'] }})" class="bg-gray-800 text-white px-4 py-2 rounded">Save
                    </button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="py-2 px-4 border-b">
                <input type="text" placeholder="City Name" wire:model="newNotification.city"
                       class="border rounded px-2 py-1 w-full">
                @error("newNotification.city")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
            <td class="py-2 px-4 border-b">
                <input type="text" placeholder="Probability of Precipitation" wire:model="newNotification.pop"
                       class="border rounded px-2 py-1 w-full">
                @error("newNotification.pop")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
            <td class="py-2 px-4 border-b">
                <input type="text" placeholder="UV Index" wire:model="newNotification.uvi"
                       class="border rounded px-2 py-1 w-full">
                @error("newNotification.uvi")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
            <td class="py-2 px-4 border-b">
                <button wire:click="addNotification" class="bg-gray-800 text-white px-4 py-2 rounded">Add</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
