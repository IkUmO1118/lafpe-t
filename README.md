# LAFPE-T (Learning Assessment for Principle Evaluation - Tool)

**[Click here for the website](https://lafpe-t.com 'open')**

## Project Overview

LAFPE-T is a web application for evaluating the performance of laboratory animal facilities. Users can assess their facilities through a diagnostic form and utilize various features such as result visualization, PDF export, and feedback submission.

## Research Background

### Significance of Laboratory Animal Facility Principle Evaluation

- **Development Background**  
  This tool is designed to comprehensively assess facility performance from architectural and equipment perspectives, aiming to determine whether the facility meets its intended use and operational policies. By reviewing the current status of their own facility, users can optimize operations, set appropriate policies, and utilize the tool for planning new constructions or renovations. The tool evaluates six axes: the five basic principles described in the guidelines (2007 edition, Architectural Institute of Japan) and the disaster plan (DP) including BCP, focusing on the operation status of facility architecture and equipment.

- **Measurement Method**  
  In the diagnostic form, users self-assess each principle by selecting from multiple options. The results are scored for each principle and visualized in graphs and PDFs.

- **Reliability and Validity**  
  The questions and evaluation methods are designed with reference to relevant research, ensuring reliability and validity.

## Technologies Used

| Category | Technology used                               |
| -------- | --------------------------------------------- |
| Frontend | React<br>TypeScript<br>Vite<br>TailwindCSS    |
| Backend  | PHP<br>Composer<br>Google Sheets API<br>TCPDF |
| Database | Google Sheets                                 |
| Server   | NGINX<br>AWS                                  |

## Folder Structure

```
lafpe-t/
├── backend/   # PHP-based API, PDF generation, Google Sheets integration
│   ├── app/
│   ├── config/
│   ├── Exceptions/
│   ├── Helper/
│   ├── public/
│   ├── Response/
│   ├── Routing/
│   ├── tests/
│   └── vendor/
├── frontend/  # React/TypeScript SPA
│   ├── src/
│   └── public/
```

## Features

- **Laboratory Animal Facility Performance Diagnosis** : Evaluation form based on key principles
- **Graphical Display of Results** : Visualization of results using radar charts, etc.
- **PDF Download** : Save diagnostic results as PDF
- **Feedback Submission** : Send opinions and feedback to the site administrator
- **Google Sheets Integration** : Save response data to Google Sheets

## Usage

- **Home** : Service overview and start diagnosis button
- **Diagnosis** : Performance diagnostic form
- **Result** : Diagnostic results, graphs, PDF download
- **Feedback** : Feedback form

## Future Enhancements

- [ ] Introduction of CI/CD pipeline
- [ ] Multilingual support
- [ ] More detailed statistical analysis features
- [ ] Specific improvement advice based on diagnostic results

## Contact

- **Email** : ikumo1118free@gmail.com
- **Phone Number** : 080-7743-8445
