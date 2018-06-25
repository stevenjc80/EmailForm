________________________________________________________________________

EmailForm Copyright (C) 2018, Steven J. Castellucci
________________________________________________________________________

Initially written in 2012, EmailForm was meant to help my parents easily
send me email in an emergency when I was travelling with little or no
cellphone coverage, but occational Internet access to check email.

I recently decided to update it to make it more robust and useful. The
"emergency.html" file is the original form page, and "contact.html" is
the updated one.

The PHP script has the destination email address hard-coded, and should
be modified as needed. In addition, there is a whitelist of referral
pages that should also be updated as necessary. This whitelist contains
the pages that are approved to use this script. Requests from all other
pages will result in error. However, referral data can be manipulated,
so this security technique is not 100% secure.
