console.log("hello");
import {NodeMailer} from 'C:/Users/GARIMA/AppData/Roaming/npm/node_modules'



  // create reusable transporter object using the default SMTP transport
  let transporter = NodeMailer.createTransport({
     // true for 465, false for other ports
    service: "gmail",
    auth: {
      user: "gaurangtyagi7@gmail.com", // generated ethereal user
      pass: "dcpsltsqkhvezisa", // generated ethereal password
    },
  });

  // send mail with defined transport object
  let info = transporter.sendMail({
    from: 'gaurangtyagi7@gmail.com', // sender address
    to: "gaurangtyagi7@gmail.com", // list of receivers
    subject: "Yo ✔", // Subject line
    text: "Hello world?", // plain text body
    html: "<b>Hello world?</b>", // html body
  });

