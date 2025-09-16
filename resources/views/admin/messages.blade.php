@extends('layouts.admin')

@section('title', 'Admin Messages')
@section('page-title', 'Admin Messages')

@section('content')
<<<<<<< Updated upstream
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Enhanced Header Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Admin Messages</h1>
                        <p class="text-sm text-gray-600 mt-1">Communicate with patients and staff members</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-bell"></i>
                    <span>Real-time notifications enabled</span>
=======
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Modern Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Messages</h1>
                    <p class="text-lg text-gray-600">Communicate with users and manage conversations</p>
>>>>>>> Stashed changes
                </div>
            </div>
        </div>

<<<<<<< Updated upstream
        <!-- Enhanced Chat Layout -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="chat-layout">
                <!-- Enhanced Sidebar -->
                <div class="chat-sidebar">
                    <div class="chat-sidebar-header">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-sm"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">Conversations</h3>
                        </div>
                    </div>
                    <div class="chat-search">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input id="user-search" type="text" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150" placeholder="Search users..." autocomplete="off">
=======
        <!-- Chat Interface -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="chat-layout">
                <div class="chat-sidebar">
                    <div class="p-4 border-b border-gray-200">
                        <div class="relative">
                            <input id="user-search" type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search users..." autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
>>>>>>> Stashed changes
                        </div>
                    </div>
                    <ul id="user-list" class="chat-user-list"></ul>
                </div>
<<<<<<< Updated upstream

                <!-- Enhanced Main Chat -->
                <div class="chat-main">
                    <div class="chat-header">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <div class="chat-header-title font-semibold text-gray-900" id="chat-title">Select a conversation</div>
                                    <div class="text-sm text-gray-500">Click on a user to start messaging</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-150" title="More options">
                                    <i class="fas fa-ellipsis-v text-gray-500 text-sm"></i>
                                </button>
=======
                <div class="chat-main">
                    <div class="chat-header">
                        <div class="flex items-center justify-between p-4 border-b border-gray-200">
                            <div class="chat-header-title" id="chat-title">Select a conversation</div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                <span class="text-sm text-gray-500">Online</span>
>>>>>>> Stashed changes
                            </div>
                        </div>
                    </div>
                    <div id="chat-box" class="chat-messages">
                        <div class="chat-empty" id="chat-empty">
<<<<<<< Updated upstream
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-comment-dots text-blue-600 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Start a conversation</h3>
                                <p class="text-gray-600">Select a user from the sidebar to begin messaging</p>
=======
                            <div class="flex flex-col items-center justify-center h-full">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-comments text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Start a conversation</h3>
                                <p class="text-gray-500">Pick a user on the left to start chatting.</p>
>>>>>>> Stashed changes
                            </div>
                        </div>
                    </div>
                    <form id="chat-form" class="chat-input" autocomplete="off">
                        <input type="hidden" id="receiver_id" name="receiver_id">
<<<<<<< Updated upstream
                        <div class="flex items-end space-x-3">
                            <div class="flex-1 relative">
                                <textarea id="message" name="message" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150 resize-none" rows="1" placeholder="Type a message..." required></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" id="send-btn" disabled>
                                <i class="fas fa-paper-plane text-sm"></i>
=======
                        <div class="flex items-end space-x-3 p-4 border-t border-gray-200">
                            <div class="flex-1">
                                <textarea id="message" name="message" class="w-full px-4 py-2 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="1" placeholder="Type a message..." required></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed" id="send-btn" disabled>
                                <i class="fas fa-paper-plane mr-2"></i>Send
>>>>>>> Stashed changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
	.chat-layout {
		display: grid;
		grid-template-columns: 320px 1fr;
		height: 70vh;
	}
	
	.chat-sidebar {
		display: flex;
		flex-direction: column;
		border-right: 1px solid #e5e7eb;
		height: 100%;
		overflow: hidden;
		border-right: 1px solid #e5e7eb;
	}
<<<<<<< Updated upstream
	
	.chat-sidebar-header {
		padding: 20px;
		border-bottom: 1px solid #e5e7eb;
		background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
		flex-shrink: 0;
=======
	.chat-user-list {
		list-style: none;
		margin: 0;
		padding: 0;
		overflow-y: auto;
		flex: 1;
>>>>>>> Stashed changes
	}
	
	.chat-search {
		padding: 16px 20px;
		border-bottom: 1px solid #e5e7eb;
		background-color: #fafbfc;
		flex-shrink: 0;
	}
	
	.chat-user-list {
		flex: 1;
		overflow-y: auto;
		overflow-x: hidden;
		padding: 0;
		margin: 0;
		list-style: none;
		background-color: #ffffff;
		min-height: 0;
		scrollbar-width: thin;
		scrollbar-color: #cbd5e1 #f8fafc;
	}
	
	.chat-user-list::-webkit-scrollbar {
		width: 6px;
	}
	
	.chat-user-list::-webkit-scrollbar-track {
		background: #f8fafc;
		border-radius: 3px;
	}
	
	.chat-user-list::-webkit-scrollbar-thumb {
		background: #cbd5e1;
		border-radius: 3px;
		transition: background-color 0.2s ease;
	}
	
	.chat-user-list::-webkit-scrollbar-thumb:hover {
		background: #94a3b8;
	}
	
	.chat-user-item {
		padding: 16px 20px;
		border-bottom: 1px solid #f3f4f6;
		cursor: pointer;
		transition: all 0.2s ease;
		display: flex;
		align-items: center;
		gap: 12px;
<<<<<<< Updated upstream
		position: relative;
	}
	
	.chat-user-item:hover {
		background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
		transform: translateX(2px);
	}
	
	.chat-user-item.active {
		background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
		color: white;
		box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
	}
	
	.chat-user-item.active::before {
		content: '';
		position: absolute;
		left: 0;
		top: 0;
		bottom: 0;
		width: 4px;
		background: #1d4ed8;
	}
	
	.chat-user-avatar {
		width: 44px;
		height: 44px;
		border-radius: 12px;
		background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
=======
		padding: 16px;
		cursor: pointer;
		border-bottom: 1px solid #f3f4f6;
		transition: all 0.2s ease-in-out;
	}
	.chat-user-item:hover { 
		background: #f8fafc; 
		border-left: 3px solid #3b82f6;
	}
	.chat-user-item.active { 
		background: #eff6ff; 
		border-left: 3px solid #3b82f6;
	}
	.chat-user-item .avatar {
		flex: 0 0 40px;
		width: 40px;
		height: 40px;
		border-radius: 50%;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: #ffffff;
>>>>>>> Stashed changes
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-weight: 600;
<<<<<<< Updated upstream
		font-size: 16px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}
	
	.chat-user-item.active .chat-user-avatar {
		background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
		color: #3b82f6;
		box-shadow: 0 2px 12px rgba(255, 255, 255, 0.3);
	}
	
	.chat-user-info {
		flex: 1;
		min-width: 0;
	}
	
	.chat-user-name {
		font-weight: 600;
		margin: 0;
		font-size: 15px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		color: #1f2937;
	}
	
	.chat-user-item.active .chat-user-name {
		color: white;
	}
	
	.chat-user-last-message {
		font-size: 13px;
		color: #6b7280;
		margin: 4px 0 0 0;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	
	.chat-user-item.active .chat-user-last-message {
		color: rgba(255, 255, 255, 0.8);
	}
	
	.chat-user-time {
		font-size: 12px;
		color: #9ca3af;
		white-space: nowrap;
		font-weight: 500;
	}
	
	.chat-user-item.active .chat-user-time {
		color: rgba(255, 255, 255, 0.9);
	}
	
	.chat-main {
		display: flex;
		flex-direction: column;
		background-color: #ffffff;
	}
	
	.chat-header {
		padding: 20px 24px;
		border-bottom: 1px solid #e5e7eb;
		background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
	}
	
	.chat-messages {
		flex: 1;
		overflow-y: auto;
		padding: 24px;
		display: flex;
		flex-direction: column;
		gap: 16px;
		background: linear-gradient(135deg, #fafbfc 0%, #f8fafc 100%);
	}
	
	.chat-empty {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
	}
	
	.chat-message {
		display: flex;
		gap: 12px;
		max-width: 75%;
		animation: fadeInUp 0.3s ease;
	}
	
	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(10px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	
	.chat-message.sent {
		align-self: flex-end;
		flex-direction: row-reverse;
	}
	
	.chat-message-avatar {
		width: 36px;
		height: 36px;
		border-radius: 10px;
		background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-weight: 600;
		font-size: 14px;
		flex-shrink: 0;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}
	
	.chat-message.sent .chat-message-avatar {
		background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
	}
	
	.chat-message-content {
		flex: 1;
	}
	
	.chat-message-bubble {
		background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
		padding: 12px 16px;
		border-radius: 16px;
		word-wrap: break-word;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
		border: 1px solid #e5e7eb;
		position: relative;
	}
	
	.chat-message.sent .chat-message-bubble {
		background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
		color: white;
		border: 1px solid #2563eb;
		box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
	}
	
	.chat-message-time {
		font-size: 11px;
		color: #9ca3af;
		margin-top: 6px;
		font-weight: 500;
	}
	
	.chat-message.sent .chat-message-time {
		text-align: right;
		color: #cbd5e1;
	}
	
	.chat-input {
		padding: 20px 24px;
		border-top: 1px solid #e5e7eb;
		background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
	}
	
	@media (max-width: 768px) {
		.chat-layout {
			grid-template-columns: 1fr;
			height: auto;
		}
		.chat-sidebar {
			height: 300px;
			border-right: none;
			border-bottom: 1px solid #e5e7eb;
		}
		.chat-main {
			height: 400px;
		}
		.chat-user-item {
			padding: 12px 16px;
		}
		.chat-sidebar-header,
		.chat-search {
			padding: 16px;
		}
		.chat-header,
		.chat-input {
			padding: 16px;
		}
		.chat-messages {
			padding: 16px;
		}
=======
		font-size: 14px;
	}
	.chat-user-item .meta { 
		display: flex; 
		flex-direction: column; 
		min-width: 0; 
		flex: 1;
	}
	.chat-user-item .name { 
		font-weight: 600; 
		white-space: nowrap; 
		overflow: hidden; 
		text-overflow: ellipsis;
		color: #1f2937;
		font-size: 14px;
	}
	.chat-user-item .role { 
		font-size: 12px; 
		color: #6b7280; 
		white-space: nowrap; 
		overflow: hidden; 
		text-overflow: ellipsis;
		margin-top: 2px;
	}

	.chat-main {
		display: grid;
		grid-template-rows: auto 1fr auto;
		flex: 1;
	}
	.chat-header-title { 
		font-weight: 600; 
		color: #1f2937;
		font-size: 16px;
	}
	.chat-messages { 
		padding: 20px; 
		overflow-y: auto; 
		background: #f8fafc;
		flex: 1;
	}
	.chat-empty { 
		color: #6b7280; 
		text-align: center; 
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.message-row { 
		display: flex; 
		margin-bottom: 16px; 
		align-items: flex-end;
	}
	.message-row.me { justify-content: flex-end; }
	.message-row.them { justify-content: flex-start; }
	.message-bubble {
		max-width: 70%;
		padding: 12px 16px;
		border-radius: 18px;
		position: relative;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	}
	.message-row.me .message-bubble { 
		background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
		color: #ffffff; 
		border-color: #3b82f6; 
	}
	.message-text { 
		white-space: pre-wrap; 
		word-wrap: break-word; 
		line-height: 1.4;
	}
	.message-time { 
		font-size: 11px; 
		opacity: 0.75; 
		margin-top: 6px; 
		text-align: right; 
>>>>>>> Stashed changes
	}
</style>

<script>
	let selectedUserId = null;
	let allUsers = [];
	let userIndex = new Map();
	let lastMessageCount = 0;
	let notificationSound = null;

	function renderUserList(users) {
		console.log('Rendering user list with', users.length, 'users');
		const list = document.getElementById('user-list');
		list.innerHTML = '';
		users.forEach(user => {
			console.log('Processing user:', user);
			const li = document.createElement('li');
			li.className = 'chat-user-item';
			li.id = 'user-' + user.id;
			
			const initials = `${(user.fname?.[0]||'').toUpperCase()}${(user.lname?.[0]||'').toUpperCase()}`;
			console.log('User initials:', initials);
			
			// Create avatar
			const avatar = document.createElement('div');
			avatar.className = 'chat-user-avatar';
			avatar.textContent = initials || 'U';
			
			// Create user info container
			const userInfo = document.createElement('div');
			userInfo.className = 'chat-user-info';
			
			// Create name element
			const name = document.createElement('div');
			name.className = 'chat-user-name';
			name.textContent = `${user.fname} ${user.lname}`.trim();
			
			// Create last message element
			const lastMessage = document.createElement('div');
			lastMessage.className = 'chat-user-last-message';
			lastMessage.textContent = user.last_message || 'No messages yet';
			
			userInfo.appendChild(name);
			userInfo.appendChild(lastMessage);
			
			// Create time element
			const time = document.createElement('div');
			time.className = 'chat-user-time';
			time.textContent = user.last_message_time || '';
			
			li.appendChild(avatar);
			li.appendChild(userInfo);
			li.appendChild(time);
			li.onclick = function() { selectUser(user.id); };
			
			if (selectedUserId === user.id) li.classList.add('active');
			list.appendChild(li);
		});
		console.log('User list rendered, total items:', list.children.length);
	}

	function loadUsers() {
		console.log('Loading users...');
		fetch('/admin/chat-users')
			.then(response => {
				console.log('Response status:', response.status);
				return response.json();
			})
			.then(users => {
				console.log('Users received:', users);
				allUsers = users;
				userIndex = new Map(users.map(u => [u.id, u]));
				renderUserList(users);
			})
			.catch(error => {
				console.error('Error loading users:', error);
			});
	}

	document.getElementById('user-search').addEventListener('input', function() {
		const q = this.value.toLowerCase();
		renderUserList(allUsers.filter(u => (
			`${u.fname || ''} ${u.lname || ''}`.toLowerCase().includes(q) ||
			(u.role || '').toLowerCase().includes(q) ||
			(u.company || '').toLowerCase().includes(q)
		)));
	});

	function selectUser(userId) {
		selectedUserId = userId;
		document.getElementById('receiver_id').value = userId;
		updateSendButtonState();
		document.querySelectorAll('.chat-user-item').forEach(el => el.classList.remove('active'));
		const selectedLi = document.getElementById('user-' + userId);
		if (selectedLi) selectedLi.classList.add('active');
		const u = userIndex.get(userId);
		document.getElementById('chat-title').textContent = u ? `${u.fname} ${u.lname}`.trim() : 'Conversation';
		loadMessages(true);
	}

	function formatTime(ts) {
		try {
			if (!ts) return '';
			const d = new Date(ts);
			if (isNaN(d.getTime())) return '';
			
			const now = new Date();
			const diffMs = now - d;
			const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
			
			if (diffDays === 0) {
				// Today - show time only
				return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
			} else if (diffDays === 1) {
				// Yesterday
				return 'Yesterday ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
			} else if (diffDays < 7) {
				// Within a week - show day and time
				return d.toLocaleDateString([], { weekday: 'short' }) + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
			} else {
				// Older - show date and time
				return d.toLocaleDateString([], { month: 'short', day: 'numeric' }) + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
			}
		} catch (_) { return ''; }
	}

	function loadMessages(forceScroll) {
		if (!selectedUserId) return;
		fetch('/admin/messages/fetch')
			.then(response => response.json())
			.then(data => {
				const chatBox = document.getElementById('chat-box');
				const empty = document.getElementById('chat-empty');
				
				// Check for new messages and show notifications
				checkForNewMessages(data);
				
				if (data.messages && data.messages.length > 0) {
					empty.style.display = 'none';
					chatBox.innerHTML = '';
					data.messages.forEach(msg => {
						const messageDiv = document.createElement('div');
						messageDiv.className = 'chat-message' + (msg.sender_id == {{ auth()->id() }} ? ' sent' : '');
						
						const avatar = document.createElement('div');
						avatar.className = 'chat-message-avatar';
						const senderUser = userIndex.get(msg.sender_id) || {};
						const initials = `${(senderUser.fname?.[0]||'').toUpperCase()}${(senderUser.lname?.[0]||'').toUpperCase()}`;
						avatar.textContent = initials || 'U';
						
						const content = document.createElement('div');
						content.className = 'chat-message-content';
						
						const bubble = document.createElement('div');
						bubble.className = 'chat-message-bubble';
						bubble.textContent = msg.message;
						
						const time = document.createElement('div');
						time.className = 'chat-message-time';
						time.textContent = formatTime(msg.created_at);
						
						content.appendChild(bubble);
						content.appendChild(time);
						messageDiv.appendChild(avatar);
						messageDiv.appendChild(content);
						chatBox.appendChild(messageDiv);
					});
					
					if (forceScroll || chatBox.scrollTop + chatBox.clientHeight >= chatBox.scrollHeight - 50) {
						chatBox.scrollTop = chatBox.scrollHeight;
					}
				} else {
					empty.style.display = 'flex';
					chatBox.innerHTML = '';
					chatBox.appendChild(empty);
				}
			});
	}

	document.getElementById('chat-form').addEventListener('submit', function(e) {
		e.preventDefault();
		if (!selectedUserId) return;
		const messageEl = document.getElementById('message');
		const text = messageEl.value.trim();
		if (!text) return;
		fetch('/admin/messages/send', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			body: JSON.stringify({
				receiver_id: selectedUserId,
				message: text
			})
		}).then(() => {
			messageEl.value = '';
			updateSendButtonState();
			loadMessages(true);
		});
	});

	function updateSendButtonState() {
		const text = document.getElementById('message').value.trim();
		document.getElementById('send-btn').disabled = !selectedUserId || text.length === 0;
	}

	document.getElementById('message').addEventListener('input', updateSendButtonState);
	// Enter to send, Shift+Enter for newline
	document.getElementById('message').addEventListener('keydown', function(e) {
		if (e.key === 'Enter' && !e.shiftKey) {
			e.preventDefault();
			if (!document.getElementById('send-btn').disabled) {
				document.getElementById('chat-form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
			}
		}
	});

	// Check for new messages and show notifications
	function checkForNewMessages(messages) {
		const currentMessageCount = messages.length;
		if (currentMessageCount > lastMessageCount && lastMessageCount > 0) {
			// New messages arrived
			showNotification('New message received');
			playNotificationSound();
		}
		lastMessageCount = currentMessageCount;
	}

	// Show browser notification
	function showNotification(message) {
		if (Notification.permission === 'granted') {
			new Notification('Admin Messages', {
				body: message,
				icon: '/favicon.ico'
			});
		} else if (Notification.permission !== 'denied') {
			Notification.requestPermission().then(permission => {
				if (permission === 'granted') {
					new Notification('Admin Messages', {
						body: message,
						icon: '/favicon.ico'
					});
				}
			});
		}
	}

	// Play notification sound
	function playNotificationSound() {
		if (notificationSound) {
			notificationSound.play().catch(e => console.log('Audio play failed:', e));
		}
	}

	function markAsRead() {
		if (!selectedUserId) return;
		fetch('/admin/messages/mark-read', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			body: JSON.stringify({ sender_id: selectedUserId })
		});
	}

	// Initialize notifications
	document.addEventListener('DOMContentLoaded', function() {
		// Request notification permission
		if (Notification.permission === 'default') {
			Notification.requestPermission();
		}
		
		// Create notification sound (optional)
		try {
			notificationSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
		} catch (e) {
			console.log('Audio not supported');
		}
	});

	setInterval(() => { loadMessages(); markAsRead(); }, 2000);
	loadUsers();
</script>
@endsection
