/*

// tutorial1.js
var CommentBox = React.createClass({
    render: function() {
        return (
            <div className="commentBox">
                Hello, world! I am a CommentBox.
            </div>
        );
    }
});
ReactDOM.render(
    <CommentBox />,
    document.getElementById('content')
);*/

// tutorial1-raw.js
var CommentBox = React.createClass({displayName: 'CommentBox_khongquantrong',
    render: function() {
        return (

                React.createElement('div', {className: "commentBox"},
                    "Hello, world! I am a CommentBox."
                )


        );
    }
});
ReactDOM.render(
    React.createElement(CommentBox, null),
    document.getElementById('content')
);

// xử lý sự kiện DOM
$(document).ready(function(){
    $(".commentBox").click(function(){
        alert("hello jaca");
        $(this).addClass('background','red');
    });
});