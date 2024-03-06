# Laravel

Create a Laravel APIs application. They will have both public and private endpoints with roles as well.

## Glossary

- **User** will have an email and a password, used for testing. 
- **Travel** is the basic, fundamental unit: it contains all the necessary information, like the number of days, the images (you don't have to implement them, don't worry!), title, what's included and everything about its *appearance*. An example is `Jordan 360°` or `Iceland: hunting for the Northern Lights`;
- **Tour** is a specific dates-range of a travel with its own price and details. `Jordan 360°` may have a *tour* from 20 to 27 January at €899, another one from 10 to 15 March at €1099 etc. At the end, you will book a *tour*, not a *travel*.
- **Role** can be one of `admin` or `editor`.

## Goals

At the end, the project should have:

1. A private (admin) endpoint to create new travels;
2. A private (admin) endpoint to create new tours for a travel;
3. A private (editor) endpoint to update a travel;
4. A public (no auth) endpoint to get a list of paginated tours by the travel `slug` (e.g. all the tours of the travel `foo-bar`). Users can filter (search) the results by `priceFrom`, `priceTo`, `dateFrom` (from that `startingDate`) and `dateTo` (until that `startingDate`). User can sort the list by `price` asc and desc. They will **always** be sorted, after every additional user-provided filter, by `startingDate` asc.

## Models

**Travel** has a flag to determine if it's public, a slug, a name, a description, the number of days, the number of nights (computed by `numberOfDays - 1`) and a set of moods (see the samples to learn more).  

**Tour** has the relationship with its travel, a name, a starting date, an ending date and the price (see below details).  

### Notes

- Feel free to use the native Laravel authentication; don't reinvent the wheel!
- We use UUIDs as primary keys instead of incremental IDs, but it's not required for you to use them, although highly appreciated;
- Our tables are in `snake_case`, but their columns are in `camelCase`.
- **Tours prices** are integer multiplied by 100: for example, €999 euro will be `99900`, but, when returned to Frontends, they will be formatted (`99900 / 100`);
- **Tours names** inside the `samples` are a kind-of what we use internally, but you can use whatever you want;
- In the `samples` folder you can find JSON files containing fake data to get started with;
- Unit/Integration/Feature tests are required to evaluate the Business Case;
- Usage of linter and static analysis tools are a **really appreciated**;
- Creating docs is **big plus**, even a README is fine;
- Users needed for the tests should be created with a seeder or whatever you feel more comfortable with;
- Code should be uploaded in a GitHub repository.

Feel free to add to the project whatever you want! 
