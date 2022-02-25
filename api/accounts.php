<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tokenize Bank Account Form - Balanced</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le styles -->
    <link href="https://twitter.github.com/bootstrap/assets/css/bootstrap.css"
          rel="stylesheet">
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css"
          rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style type="text/css">
            /* some styles to make the form standout */
        body {
            background: #c0c1c3;
        }
        #form-container {
            background: #FCFCFC;
            border-radius: 10px;
            border: 1px solid #999;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.20), inset 0 1px 0 white;
        }
    </style>
    <style type="text/css">
            /* some styles to wrangle bootstrap into behaving for us */
        .controls-row > span.control-group {
            margin-left: 0;
            margin-bottom: 0;
        }
        .controls-row .control-group + .control-group {
            margin-left: 30px;
            display: inline-block;
        }
        .controls-row .errors {
            vertical-align: top;
            display: inline-block;
            float: none;
            margin-left: 10px;
            width: 180px;
        }
        .errors.error .help-inline {
            color: #B94A48;
        }
        .button-here {
            text-align: right;
        }
        .help-inline {
            padding-top: 5px;
            vertical-align: top;
        }
        /* hack: some weird whitespace issue... */
        .controls + .controls .help-inline {
            padding-left: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Balanced</h1>
    <div class="row">
        <div class="offset3 span6" id="form-container">
            <!-- Begin Balanced ACH Form -->
            <form class="" id="ach-form">
                <formset>
                    <legend>Bank account</legend>
                <div class="controls controls-row">
                    <span class="control-group">
                    <input type="text" id="name" name="name"
                           placeholder="Account holder's name"
                           autofocus="autofocus" class="span4"></span>
                    <span class="errors span2">

                    </span>
                </div>
                <div class="controls controls-row">
                    <span class="control-group">
                    <input type="text" id="routing_number" name="routing_number"
                           placeholder="Routing number" maxlength="9"
                           class="span2">
                    </span>
                    <span class="control-group">
                    <input type="text" id="account_number" name="account_number"
                           placeholder="Account number" class="span2"
                           autocomplete="off">
                    </span>
                    <span class="errors span2">

                    </span>
                </div>
                <div class="control-group">
                    <div class="controls controls-row">
                        <select id="type" class="span2" name="type">
                            <option value="savings">Savings</option>
                            <option value="checking">Checking</option>
                        </select>
                        <div class="span2 button-here">
                            <button type="submit" class="btn btn-success">Create account</button>

                        </div>
                    </div>
                    </div>
                </formset>
            </form>
            <!-- End Balanced ACH Form -->
        </div>
    </div>
</div>
<script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript"
        src="https://js.balancedpayments.com/v1/balanced.js"></script>
<script type="text/javascript">
    var marketplaceUri = '/v1/marketplaces/MP5Pg8XIUxdZn4L8gbcIfy2t';

    try {
        balanced.init(marketplaceUri);
    } catch (e) {
        console.error('You need to set the marketplaceUri variable');
    }

    $.fn.showError = function (message, cls) {
        var eclass = cls || 'error';
        var $this = $(this), $ctrls = $this.closest('.controls');
        $this.closest('.control-group').addResponseClass(eclass);
        var $help = $ctrls.find('.help-inline');
        var $appendTo = $ctrls.find('.errors').addResponseClass(eclass).show();
        if (!$appendTo.length) {
            $appendTo = $ctrls;
        }
        if (!$help.length) {
            $help = $('<span class="help-inline"></span>');
            $help.appendTo($appendTo);
        }
        $help.text(message).show();
        return this;
    };

    $.fn.disableForm = function () {
        $(this).find('input,select,button').attr('disabled', 'disabled');
        return this;
    };

    $.fn.enableForm = function () {
        $(this).find('input,select,button').removeAttr('disabled');
    };

    $.fn.clearErrors = function () {
        $(this).find('.error').addResponseClass().find('.help-inline').hide();
        $(this).find('.errors').addResponseClass().hide();
        return this;
    };

    $.fn.clearError = function (cls) {
        $(this).closest('.control-group').addResponseClass(cls).closest('.controls').find('.errors .help-inline').hide();
        return this;
    };

    $.fn.addResponseClass = function (cls) {
        return $(this).removeClass('error success').addClass(cls);
    };

    function balancedCallback(response) {
        console.log(response);
        switch (response.status) {
            case 201:
                // response.data.uri == uri of the bank account resource
                console.log('success', response.data.uri);
                // submit to your server
                $.post('/url/of/your/server', response.data);
            case 400:
            case 403:
                $('#ach-form').enableForm();
                // missing/malformed data - check response.error for details
                var errors = response.error;
                if (errors) {
                    if ('extras' in errors) {
                        errors = errors.extras;
                    }
                    for (var key in errors) {
                        if (!errors.hasOwnProperty(key)) {
                            continue;
                        }
                        $('[name^="' + key + '"]').showError(errors[key]);
                        $('.error input, .error select').first().focus();
                    }
                }
                break;
            case 404:
                $('#ach-form').enableForm();
                console.error('Marketplace URI is incorrect');
                break;
        }
    }

    var tokenizeBankAccount = function (e) {
        e.preventDefault();

        var $form = $('#ach-form').clearErrors().disableForm();
        var bankAccountData = {
            name:$form.find('[name="name"]').val(),
            account_number:$form.find('[name="account_number"]').val(),
            routing_number:$form.find('[name="routing_number"]').val()
        };
        balanced.bankAccount.create(bankAccountData, balancedCallback);
    };

    function lookupRoutingNumber(e) {
        var rn = $(this).val();
        var callback = function (response) {
            console.log('routing number lookup response', response, response.status);
            var $e = $('[name^="routing_number"]');
            if (response.status === 200) {
                $e.showError(response.data.customer_name, 'success');
            } else {
                $e.showError('Invalid routing number');
            }
        };
        balanced.bankAccount.lookupRoutingNumber(rn, callback);
    }

    $(function () {
        $('#ach-form').submit(tokenizeBankAccount);
        $('[name^="name"]').blur(function (e) {
            console.log('validating name');
            var $el = $(this);
            if ($el.val().length >= 2) {
                $el.clearError('success');
            } else {
                $el.showError('Missing field', 'error');
            }

        });
        $('[name^="routing_number"]').blur(lookupRoutingNumber);
        $('[name^="account_number"]').blur(function (e) {
            console.log('validating account_number');
            var $el = $(this);
            if ($el.val().length >= 2) {
                $el.clearError('success');
            } else {
                $el.showError('Missing field', 'error');
            }
        });
    });

    if (window.location.protocol === 'file:') {
        alert("balanced.js does not work when included in pages served over file:// URLs. Try serving this page over a webserver. Contact support@balancedpayments.com if you need assistance.");
    }
</script>

</body>
</html>