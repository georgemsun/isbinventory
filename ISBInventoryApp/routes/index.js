var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

/* GET ISBinventory page. */
router.get('/ISBinventory', function(req, res) {
    var db = req.db;
    var collection = db.get('inventory');
    collection.find({},{},function(e,docs){
        res.render('ISBinventory', {
            "ISBinventory" : docs
        });
    });
});

/* GET helloworld page. */
router.get('/helloworld', function(req, res){
  res.render('helloworld', {title: 'Hello, World!'})
});

/* GET bootstrap test page. */
router.get('/bootstraptest', function(req, res){
  res.render('bootstraptest', {title: 'bootstrap test'})
});
module.exports = router;
