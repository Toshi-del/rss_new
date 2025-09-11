@extends('layouts.company')

@section('content')
<div class="container py-4">
	<h2 class="mb-3">Messages</h2>
	<div class="chat-layout">
		<div class="chat-sidebar">
			<div class="chat-search">
				<input id="user-search" type="text" class="form-control" placeholder="Search users..." autocomplete="off">
			</div>
			<ul id="user-list" class="chat-user-list"></ul>
		</div>
		<div class="chat-main">
			<div class="chat-header">
				<div class="chat-header-title" id="chat-title">Select a conversation</div>
			</div>
			<div id="chat-box" class="chat-messages">
				<div class="chat-empty" id="chat-empty">Pick a user on the left to start chatting.</div>
			</div>
			<form id="chat-form" class="chat-input" autocomplete="off">
				<input type="hidden" id="receiver_id" name="receiver_id">
				<textarea id="message" name="message" class="form-control" rows="1" placeholder="Type a message..." required></textarea>
				<button type="submit" class="btn btn-primary" id="send-btn" disabled>Send</button>
			</form>
		</div>
	</div>
</div>

<style>
	.chat-layout {
		display: grid;
		grid-template-columns: 320px 1fr;
		gap: 16px;
		height: 70vh;
	}
	.chat-sidebar {
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 8px;
		display: flex;
		flex-direction: column;
		overflow: hidden;
	}
	.chat-search { padding: 12px; border-bottom: 1px solid #e5e7eb; }
	.chat-user-list {
		list-style: none;
		margin: 0;
		padding: 0;
		overflow-y: auto;
	}
	.chat-user-item {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 12px;
		cursor: pointer;
		border-bottom: 1px solid #f3f4f6;
		transition: background 0.15s ease-in-out;
	}
	.chat-user-item:hover { background: #f9fafb; }
	.chat-user-item.active { background: #eef2ff; }
	.chat-user-item .avatar {
		flex: 0 0 36px;
		width: 36px;
		height: 36px;
		border-radius: 9999px;
		background: #6366f1;
		color: #ffffff;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: 600;
	}
	.chat-user-item .meta { display: flex; flex-direction: column; min-width: 0; }
	.chat-user-item .name { font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
	.chat-user-item .role { font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

	.chat-main {
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 8px;
		display: grid;
		grid-template-rows: auto 1fr auto;
	}
	.chat-header { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
	.chat-header-title { font-weight: 600; }
	.chat-messages { padding: 16px; overflow-y: auto; background: #f9fafb; }
	.chat-empty { color: #6b7280; text-align: center; margin-top: 24px; }
	.message-row { display: flex; margin-bottom: 10px; }
	.message-row.me { justify-content: flex-end; }
	.message-row.them { justify-content: flex-start; }
	.message-bubble {
		max-width: 70%;
		padding: 10px 12px;
		border-radius: 14px;
		position: relative;
		background: #ffffff;
		border: 1px solid #e5e7eb;
	}
	.message-row.me .message-bubble { background: #4f46e5; color: #ffffff; border-color: #4f46e5; }
	.message-text { white-space: pre-wrap; word-wrap: break-word; }
	.message-time { font-size: 11px; opacity: 0.75; margin-top: 6px; text-align: right; }
	.chat-input {
		display: grid; 
		grid-template-columns: 1fr auto;
		gap: 8px;
		padding: 12px;
		border-top: 1px solid #e5e7eb;
	}
</style>

<script>
	let selectedUserId = null;
	let allUsers = [];
	let userIndex = new Map();
	let lastMessageCount = 0;
	let notificationSound = null;

	function renderUserList(users) {
		const list = document.getElementById('user-list');
		list.innerHTML = '';
		users.forEach(user => {
			const li = document.createElement('li');
			li.className = 'chat-user-item';
			li.id = 'user-' + user.id;
			const initials = `${(user.fname?.[0]||'').toUpperCase()}${(user.lname?.[0]||'').toUpperCase()}`;
			const avatar = document.createElement('div');
			avatar.className = 'avatar';
			avatar.textContent = initials || 'U';
			const meta = document.createElement('div');
			meta.className = 'meta';
			const name = document.createElement('div');
			name.className = 'name';
			name.textContent = `${user.fname} ${user.lname}`.trim();
			const role = document.createElement('div');
			role.className = 'role';
			role.textContent = `${user.role || ''}${user.company ? ' • ' + user.company : ''}`.trim();
			meta.appendChild(name);
			meta.appendChild(role);
			li.appendChild(avatar);
			li.appendChild(meta);
			li.onclick = function() { selectUser(user.id); };
			if (selectedUserId === user.id) li.classList.add('active');
			list.appendChild(li);
		});
	}

	function loadUsers() {
		fetch('/company/chat-users')
			.then(response => response.json())
			.then(users => {
				allUsers = users;
				userIndex = new Map(users.map(u => [u.id, u]));
				renderUserList(users);
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
		fetch('/company/messages/fetch')
			.then(response => response.json())
			.then(data => {
				const chatBox = document.getElementById('chat-box');
				const empty = document.getElementById('chat-empty');
				chatBox.innerHTML = '';
				
				// Check for new messages and show notifications
				checkForNewMessages(data);
				
				const filtered = data.filter(msg => (msg.sender_id == selectedUserId || msg.receiver_id == selectedUserId));
				if (filtered.length === 0) {
					const blank = document.createElement('div');
					blank.className = 'chat-empty';
					blank.textContent = 'No messages yet. Say hello!';
					chatBox.appendChild(blank);
				} else {
					filtered.forEach(msg => {
						const isMe = msg.sender_id == {{ auth()->id() }};
						const row = document.createElement('div');
						row.className = 'message-row ' + (isMe ? 'me' : 'them');
						const bubble = document.createElement('div');
						bubble.className = 'message-bubble';
						const text = document.createElement('div');
						text.className = 'message-text';
						text.textContent = msg.message || '';
						const time = document.createElement('div');
						time.className = 'message-time';
						
						// Improved status display
						let status = '';
						if (isMe) {
							if (msg.read_at) {
								status = ' • Read ' + formatTime(msg.read_at);
							} else if (msg.delivered_at) {
								status = ' • Delivered ' + formatTime(msg.delivered_at);
							} else {
								status = ' • Sent';
							}
						} else {
							if (msg.read_at) {
								status = ' • Seen ' + formatTime(msg.read_at);
							} else if (msg.delivered_at) {
								status = ' • Delivered';
							}
						}
						
						time.textContent = formatTime(msg.created_at) + status;
						bubble.appendChild(text);
						bubble.appendChild(time);
						row.appendChild(bubble);
						chatBox.appendChild(row);
					});
				}
				if (forceScroll) {
					chatBox.scrollTop = chatBox.scrollHeight;
				}
			});
	}

	document.getElementById('chat-form').addEventListener('submit', function(e) {
		e.preventDefault();
		if (!selectedUserId) return;
		const messageEl = document.getElementById('message');
		const text = messageEl.value.trim();
		if (!text) return;
		fetch('/company/messages/send', {
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
				// Trigger the existing submit handler
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
			new Notification('Company Messages', {
				body: message,
				icon: '/favicon.ico'
			});
		} else if (Notification.permission !== 'denied') {
			Notification.requestPermission().then(permission => {
				if (permission === 'granted') {
					new Notification('Company Messages', {
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

	// Mark messages as read shortly after viewing
	function markAsRead() {
		if (!selectedUserId) return;
		fetch('/company/messages/mark-read', {
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
