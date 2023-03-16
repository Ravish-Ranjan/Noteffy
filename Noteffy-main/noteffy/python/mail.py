# this function sends the mail to given/default email the simple/html based text with/without attachement 
def sendmail(from_ = "noteffy.email@gmail.com" , passwd = "qlugelfypfizxlzt",to = "",subject = "",body = "",attachment = "",html=False):
    import smtplib
    from email.mime.multipart import MIMEMultipart
    from email.mime.text import MIMEText
    from email.mime.base import MIMEBase
    from email import encoders
    sender = from_ #sender-your email
    password= passwd #password
    msg = MIMEMultipart()
    msg['From'] = sender
    msg['To'] = to
    msg['Subject'] = subject
    body = body
    if html:
        msg.attach(MIMEText(body, 'html'))
    else:
        msg.attach(MIMEText(body, 'plain'))
    if attachment == "" or attachment == None:
        s = smtplib.SMTP('smtp.gmail.com', 587)
        s.starttls()
        s.login(sender, password)
        text = msg.as_string()
        s.sendmail(sender, to, text)
        s.quit()
        return
    else:
        filename = attachment.split('\\').pop()
        filename = "\\".join(filename)
        attachment = open(attachment, "rb")
        p = MIMEBase('application', 'octet-stream')
        p.set_payload((attachment).read())
        encoders.encode_base64(p)
        p.add_header('Content-Disposition', "attachment; filename= %s" % filename)
        msg.attach(p)
    s = smtplib.SMTP('smtp.gmail.com', 587)
    s.starttls()
    s.login(sender, passwd)
    text = msg.as_string()
    s.sendmail(sender, to, text)
    s.quit()
    return

import sys
data = sys.argv
# data[0] = mail.py   data[1] = recievers mail  data[2] = otp
import random
otp = random.randint(1000,9999)
msg1 = """<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
        <div style='margin:50px auto;width:70%;padding:20px 0'>
          <div style='border-bottom:1px solid #eee'>
            <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Noteffy</a>
          </div>
          <p style='font-size:1.1em'>Hi,</p>
          <p>Thank you for choosing Noteffy. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
          <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>{}</h2>
          <p style='font-size:0.9em;'>Regards,<br />Noteffy</p>
          <hr style='border:none;border-top:1px solid #eee' />
          <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
            <p>Noteffy</p>
            <p>Near my <b>ASS</b></p>
            <p>New Delhi</p>
          </div>
        </div>
      </div>
        """.format(data[3])
msg2 = """<div style='font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2'>
        <div style='margin:50px auto;width:70%;padding:20px 0'>
          <div style='border-bottom:1px solid #eee'>
            <a href='' style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Noteffy</a>
          </div>
          <p style='font-size:1.1em'>Hey there,clear your to do list</p>
          <p>{}</p>
          <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'></h2>
          <p style='font-size:0.9em;'>Regards,<br />Noteffy</p>
          <hr style='border:none;border-top:1px solid #eee' />
          <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
            <p>Noteffy</p>
            <p>Near my <b>ASS</b></p>
            <p>New Delhi</p>
          </div>
        </div>
      </div>
        """.format(data[3])
if int(data[2]) == 1:
    sendmail(to=data[1],
             subject="Otp for SignUp",
             body=msg1,
             html=True)
elif int(data[2]) == 2:
    sendmail(to=data[1],
             subject="Hey There, Noteffy Here...",
             body=msg2,
             html=True)
print(otp)
# calling to send the mail based on command line args
#html true to enable html styling otherwise false
