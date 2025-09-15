@extends('layouts.pathologist')

@section('title', 'Messages')
@section('page-title', 'Messages')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-full">
    <!-- Chat Users List -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-users mr-2 text-teal-600"></i>Contacts
                </h3>
            </div>
            <div class="p-4">
                <div id="chatUsers" class="space-y-3">
                    <!-- Users will be loaded here via JavaScript -->
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-gray-400 text-2xl mb-3"></i>
                        <p class="text-gray-500">Loading contacts...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
            <!-- Chat Header -->
            <div id="chatHeader" class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-teal-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Select a contact to start chatting</h3>
                        <p class="text-sm text-gray-600">Choose from the contacts list to begin messaging</p>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="messagesArea" class="flex-1 p-6 overflow-y-auto bg-gray-50">
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No conversation selected</h3>
                        <p class="text-gray-500">Select a contact from the list to start messaging</p>
                    </div>
                </div>
            </div>

            <!-- Message Input -->
            <div id="messageInput" class="p-6 border-t border-gray-200 bg-white hidden">
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="text" id="messageText" placeholder="Type your message..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    </div>
                    <button id="sendMessage" class="bg-gradient-to-r from-teal-600 to-blue-600 text-white px-6 py-3 rounded-lg hover:from-teal-700 hover:to-blue-700 transition-all">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden elements for current conversation -->
<input type="hidden" id="currentReceiverId" value="">
<input type="hidden" id="currentReceiverName" value="">

@endsection

@section('scripts')
<script>
    let currentReceiverId = null;
    let messages = [];
    let messageInterval;

    // Load chat users on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadChatUsers();
    });

    // Load chat users
    function loadChatUsers() {
        fetch('/pathologist/chat-users')
            .then(response => response.json())
            .then(data => {
                displayChatUsers(data.filtered_users);
            })
            .catch(error => {
                console.error('Error loading chat users:', error);
                document.getElementById('chatUsers').innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl mb-3"></i>
                        <p class="text-red-500">Error loading contacts</p>
                    </div>
                `;
            });
    }

    // Display chat users
    function displayChatUsers(users) {
        const chatUsersDiv = document.getElementById('chatUsers');
        
        if (users.length === 0) {
            chatUsersDiv.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-user-slash text-gray-300 text-2xl mb-3"></i>
                    <p class="text-gray-500">No contacts available</p>
                </div>
            `;
            return;
        }

        chatUsersDiv.innerHTML = users.map(user => `
            <div class="chat-user-item p-3 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors border border-gray-200" 
                 onclick="selectUser(${user.id}, '${user.fname} ${user.lname}', '${user.role}')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-${user.role === 'admin' ? 'purple' : 'blue'}-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-${user.role === 'admin' ? 'purple' : 'blue'}-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">${user.fname} ${user.lname}</h4>
                        <p class="text-sm text-gray-600 capitalize">${user.role}</p>
                    </div>
                    ${user.unread_count > 0 ? `
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">
                            ${user.unread_count}
                        </span>
                    ` : ''}
                </div>
            </div>
        `).join('');
    }

    // Select user for chat
    function selectUser(userId, userName, userRole) {
        currentReceiverId = userId;
        
        // Update UI
        document.getElementById('currentReceiverId').value = userId;
        document.getElementById('currentReceiverName').value = userName;
        
        // Update chat header
        document.getElementById('chatHeader').innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-${userRole === 'admin' ? 'purple' : 'blue'}-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-${userRole === 'admin' ? 'purple' : 'blue'}-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">${userName}</h3>
                    <p class="text-sm text-gray-600 capitalize">${userRole}</p>
                </div>
            </div>
        `;
        
        // Show message input
        document.getElementById('messageInput').classList.remove('hidden');
        
        // Load messages
        loadMessages();
        
        // Mark messages as read
        markAsRead(userId);
        
        // Start polling for new messages
        startMessagePolling();
        
        // Update chat user selection
        document.querySelectorAll('.chat-user-item').forEach(item => {
            item.classList.remove('bg-teal-50', 'border-teal-300');
        });
        event.currentTarget.classList.add('bg-teal-50', 'border-teal-300');
    }

    // Load messages
    function loadMessages() {
        fetch('/pathologist/fetch-messages')
            .then(response => response.json())
            .then(data => {
                messages = data;
                displayMessages();
            })
            .catch(error => {
                console.error('Error loading messages:', error);
            });
    }

    // Display messages
    function displayMessages() {
        const messagesArea = document.getElementById('messagesArea');
        const currentUserId = {{ Auth::id() }};
        
        // Filter messages for current conversation
        const conversationMessages = messages.filter(msg => 
            (msg.sender_id == currentUserId && msg.receiver_id == currentReceiverId) ||
            (msg.sender_id == currentReceiverId && msg.receiver_id == currentUserId)
        );
        
        if (conversationMessages.length === 0) {
            messagesArea.innerHTML = `
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <i class="fas fa-comment-slash text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                        <p class="text-gray-500">Start the conversation by sending a message</p>
                    </div>
                </div>
            `;
            return;
        }
        
        messagesArea.innerHTML = conversationMessages.map(msg => {
            const isOwnMessage = msg.sender_id == currentUserId;
            const messageTime = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            return `
                <div class="flex ${isOwnMessage ? 'justify-end' : 'justify-start'} mb-4">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwnMessage ? 'bg-teal-600 text-white' : 'bg-white border border-gray-200'}">
                        <p class="text-sm">${msg.message}</p>
                        <p class="text-xs mt-1 ${isOwnMessage ? 'text-teal-100' : 'text-gray-500'}">${messageTime}</p>
                    </div>
                </div>
            `;
        }).join('');
        
        // Scroll to bottom
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    // Send message
    function sendMessage() {
        const messageText = document.getElementById('messageText');
        const message = messageText.value.trim();
        
        if (!message || !currentReceiverId) return;
        
        fetch('/pathologist/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                receiver_id: currentReceiverId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }
            
            // Add message to local array
            messages.push(data);
            displayMessages();
            
            // Clear input
            messageText.value = '';
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Failed to send message');
        });
    }

    // Mark messages as read
    function markAsRead(senderId) {
        fetch('/pathologist/mark-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                sender_id: senderId
            })
        })
        .then(response => response.json())
        .then(data => {
            // Reload chat users to update unread counts
            loadChatUsers();
        })
        .catch(error => {
            console.error('Error marking messages as read:', error);
        });
    }

    // Start polling for new messages
    function startMessagePolling() {
        if (messageInterval) {
            clearInterval(messageInterval);
        }
        
        messageInterval = setInterval(() => {
            if (currentReceiverId) {
                loadMessages();
                loadChatUsers();
            }
        }, 3000); // Poll every 3 seconds
    }

    // Stop polling when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (messageInterval) {
                clearInterval(messageInterval);
            }
        } else {
            if (currentReceiverId) {
                startMessagePolling();
            }
        }
    });

    // Event listeners
    document.getElementById('sendMessage').addEventListener('click', sendMessage);
    document.getElementById('messageText').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Clean up on page unload
    window.addEventListener('beforeunload', function() {
        if (messageInterval) {
            clearInterval(messageInterval);
        }
    });
</script>
@endsection
