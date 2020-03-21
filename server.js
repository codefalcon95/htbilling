const express = require("express");
const app = express();
const port = 3000;
const fs = require('fs');
const router = new express.Router();

app.use(express.json());
app.post('/bill_merchant',  (req,res) => {
   
        setTimeout(()=> {
                res.send({status: 'success',message : 'Request completed successfully',user:req.body.username});
               
        },1600);
});

app.listen(port, () => {
  console.log(`Demo Server starts at port ${port}`);
});
