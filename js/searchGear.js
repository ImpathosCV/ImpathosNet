// Filters: Price[Low / High], Favorites, Relevance, Alphabet[Both Ways]


// Filter Details:
// Relevance - Check string against first parts of name, break if not right, those are first, check anywhere in the string for the string, those are second, check for letters in order, those are third
// Price - if no price then place last in no particular order, loop through gears and add id:price to a dict then use a sort function to sort the ids by price Switch sign for low/high
// Favorites - Similar idea as price but with the favorite count
// Alphabet - ask phind