<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .email-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .appointment-details {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .appointment-details h3 {
            margin: 0 0 15px 0;
            color: #1e40af;
            font-size: 16px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #4b5563;
        }
        .detail-value {
            color: #1f2937;
        }
        .test-details {
            background: #ecfdf5;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
        }
        .test-details h3 {
            margin: 0 0 15px 0;
            color: #065f46;
            font-size: 16px;
        }
        .test-item {
            background: white;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #d1fae5;
        }
        .test-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }
        .test-category {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .test-price {
            font-weight: 600;
            color: #059669;
        }
        .instructions {
            background: #fef3c7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
        .instructions h3 {
            margin: 0 0 15px 0;
            color: #92400e;
            font-size: 16px;
        }
        .instructions ul {
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
            color: #78350f;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 15px;
            font-size: 12px;
            color: #9ca3af;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px 15px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🏥 Appointment Confirmed</h1>
            <p>RSS Citi Health Services</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $appointmentData['customer_name'] ?? 'Patient' }},
            </div>
            
            <p>Thank you for scheduling your medical test appointment with RSS Citi Health Services. Your appointment has been successfully added to our system.</p>
            
            <div class="appointment-details">
                <h3>📅 Appointment Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Patient Name:</span>
                    <span class="detail-value">{{ $appointmentData['customer_name'] ?? 'Not specified' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $appointmentData['customer_email'] ?? 'Not specified' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Appointment Date:</span>
                    <span class="detail-value">
                        @if($appointmentData['appointment_date'])
                            {{ \Carbon\Carbon::parse($appointmentData['appointment_date'])->format('F j, Y') }}
                        @else
                            To be scheduled
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Appointment Time:</span>
                    <span class="detail-value">
                        @if($appointmentData['appointment_time'])
                            {{ \Carbon\Carbon::parse($appointmentData['appointment_time'])->format('g:i A') }}
                        @else
                            To be scheduled
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="test-details">
                <h3>🧪 Medical Test Information</h3>
                <div class="test-item">
                    <div class="test-name">{{ $testDetails['name'] }}</div>
                    @if($testDetails['category'])
                        <div class="test-category">Category: {{ $testDetails['category'] }}</div>
                    @endif
                    @if($testDetails['price'] > 0)
                        <div class="test-price">Price: ₱{{ number_format($testDetails['price'], 2) }}</div>
                    @endif
                </div>
            </div>
            
            <div class="instructions">
                <h3>📋 Important Instructions</h3>
                <ul>
                    <li>Please arrive 15 minutes before your scheduled appointment time</li>
                    <li>Bring a valid government-issued ID</li>
                    <li>If fasting is required for your test, please fast for 8-12 hours before your appointment</li>
                    <li>Wear comfortable clothing that allows easy access to your arms</li>
                    <li>If you need to reschedule, please contact us at least 24 hours in advance</li>
                </ul>
            </div>
            
            <p>If you have any questions or need to make changes to your appointment, please don't hesitate to contact us.</p>
            
            <p>We look forward to serving you!</p>
            
            <p><strong>RSS Citi Health Services Team</strong></p>
        </div>
        
        <div class="footer">
            <p><strong>RSS Citi Health Services</strong></p>
            <div class="contact-info">
                <p>📧 Email: info@rsscitihealth.com | 📞 Phone: (02) 8123-4567</p>
                <p>📍 Address: Your Clinic Address Here</p>
                <p>This is an automated message. Please do not reply to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
