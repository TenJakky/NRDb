Nette.validators.AppValidatorCoreValidator_greaterEqual = function(elem, args, val)
{
    return val >= $(elem).closest('form').find('input[name="'+args+'"]').val();
};

Nette.validators.AppValidatorCoreValidator_greater = function(elem, args, val)
{
    return val > $(elem).closest('form').find('input[name="'+args+'"]').val();
};

Nette.validators.AppValidatorCoreValidator_lessEqual = function(elem, args, val)
{
    return val <= $(elem).closest('form').find('input[name="'+args+'"]').val();
};

Nette.validators.AppValidatorCoreValidator_less = function(elem, args, val)
{
    return val < $(elem).closest('form').find('input[name="'+args+'"]').val();
};
