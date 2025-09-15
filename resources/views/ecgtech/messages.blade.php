@extends('layouts.ecgtech')

@section('title', 'Messages')

@section('page-title', 'Messages')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Messages Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">
                    <i class="fas fa-comments mr-3 text-green-600"></i>Messages
                </h2>
                <p class="text-gray-600 text-sm mt-1">Communicate with doctors and administrators</p>
            </div>
            <div class="flex items-center space-x-3">
                <button id="refreshButton" onclick="refreshMessages()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contacts List -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Contacts</h3>
            </div>
            <div id="contactsList" class="divide-y divide-gray-200">
                <!-- Contacts will be loaded here -->
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                    <p>Loading contacts...</p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm flex flex-col">
            <div id="messagesHeader" class="p-4 border-b border-gray-200 hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800" id="contactName">Contact Name</h4>
                            <p class="text-sm text-gray-500" id="contactRole">Role</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500" id="lastSeen">Last seen recently</span>
                    </div>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-1 p-4 overflow-y-auto max-h-96">
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-comments text-4xl mb-4"></i>
                    <p>Select a contact to start messaging</p>
                </div>
            </div>

            <!-- Message Input -->
            <div id="messageInput" class="p-4 border-t border-gray-200 hidden">
                <form id="messageForm" class="flex space-x-3">
                    <input type="hidden" id="receiverId" name="receiver_id">
                    <div class="flex-1">
                        <textarea id="messageText" name="message" rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 resize-none"
                                  placeholder="Type your message..." required></textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentReceiverId = null;
let messageInterval = null;

// Load contacts on page load
document.addEventListener('DOMContentLoaded', function() {
    loadContacts();
});

function loadContacts() {
    console.log('loadContacts() called');
    return fetch('/ecgtech/chat-users')
        .then(response => {
            console.log('Contacts response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Contacts data received:', data);
            if (data.error) {
                throw new Error(data.error);
            }
            displayContacts(data.filtered_users);
        })
        .catch(error => {
            console.error('Error loading contacts:', error);
            document.getElementById('contactsList').innerHTML = '<div class="p-4 text-center text-red-500">Error loading contacts: ' + error.message + '</div>';
        });
}

function displayContacts(contacts) {
    const contactsList = document.getElementById('contactsList');
    
    if (contacts.length === 0) {
        contactsList.innerHTML = '<div class="p-4 text-center text-gray-500">No contacts available</div>';
        return;
    }

    contactsList.innerHTML = contacts.map(contact => `
        <div class="p-4 hover:bg-gray-50 cursor-pointer contact-item" onclick="selectContact(${contact.id}, '${contact.fname} ${contact.lname}', '${contact.role}')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">${contact.fname} ${contact.lname}</h4>
                        <p class="text-sm text-gray-500">${contact.role}</p>
                    </div>
                </div>
                ${contact.unread_count > 0 ? `<span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">${contact.unread_count}</span>` : ''}
            </div>
        </div>
    `).join('');
}

function selectContact(receiverId, name, role) {
    currentReceiverId = receiverId;
    
    // Update UI
    document.getElementById('contactName').textContent = name;
    document.getElementById('contactRole').textContent = role;
    document.getElementById('receiverId').value = receiverId;
    
    // Show message area
    document.getElementById('messagesHeader').classList.remove('hidden');
    document.getElementById('messageInput').classList.remove('hidden');
    
    // Update contact selection
    document.querySelectorAll('.contact-item').forEach(item => {
        item.classList.remove('bg-green-50', 'border-r-2', 'border-green-600');
    });
    event.currentTarget.classList.add('bg-green-50', 'border-r-2', 'border-green-600');
    
    // Load messages
    loadMessages();
    
    // Start auto-refresh
    if (messageInterval) clearInterval(messageInterval);
    messageInterval = setInterval(loadMessages, 3000);
}

function loadMessages() {
    if (!currentReceiverId) return;
    
    fetch('/ecgtech/fetch-messages')
        .then(response => response.json())
        .then(messages => {
            // Filter messages between current user and selected contact
            const filteredMessages = messages.filter(msg => 
                (msg.sender_id == currentReceiverId && msg.receiver_id == {{ Auth::id() }}) ||
                (msg.sender_id == {{ Auth::id() }} && msg.receiver_id == currentReceiverId)
            );
            
            displayMessages(filteredMessages);
            
            // Mark messages as read
            markAsRead();
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
}

function displayMessages(messages) {
    const container = document.getElementById('messagesContainer');
    
    if (messages.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-500 py-8">No messages yet. Start the conversation!</div>';
        return;
    }
    
    container.innerHTML = messages.map(message => {
        const isOwn = message.sender_id == {{ Auth::id() }};
        const time = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        return `
            <div class="flex ${isOwn ? 'justify-end' : 'justify-start'} mb-4">
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800'}">
                    <p class="text-sm">${message.message}</p>
                    <p class="text-xs mt-1 ${isOwn ? 'text-green-100' : 'text-gray-500'}">${time}</p>
                </div>
            </div>
        `;
    }).join('');
    
    // Scroll to bottom
    container.scrollTop = container.scrollHeight;
}

function markAsRead() {
    if (!currentReceiverId) return;
    
    fetch('/ecgtech/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            sender_id: currentReceiverId
        })
    });
}

// Send message
document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/ecgtech/send-message', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
            return;
        }
        
        // Clear input
        document.getElementById('messageText').value = '';
        
        // Reload messages
        loadMessages();
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Error sending message');
    });
});

function refreshMessages() {
    console.log('Refresh button clicked');
    console.log('Current receiver ID:', currentReceiverId);
    
    // Show loading state
    const refreshButton = document.getElementById('refreshButton');
    const originalContent = refreshButton.innerHTML;
    refreshButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Refreshing...';
    refreshButton.disabled = true;
    
    if (currentReceiverId) {
        console.log('Loading messages for receiver:', currentReceiverId);
        loadMessages();
    } else {
        console.log('No receiver selected, skipping message load');
    }
    
    console.log('Loading contacts...');
    loadContacts().finally(() => {
        // Reset button state
        refreshButton.innerHTML = originalContent;
        refreshButton.disabled = false;
    });
}

// Clean up interval on page unload
window.addEventListener('beforeunload', function() {
    if (messageInterval) clearInterval(messageInterval);
});
</script>
@endsection
