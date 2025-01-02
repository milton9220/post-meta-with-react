/**
 * Admin  Page
 */
import App from './components/App'
import ReactDOM from 'react-dom/client';


// Container
const addContainer = document.getElementById('post-meta-react-container');

if (addContainer != null){
    // Root
    const root = ReactDOM.createRoot(addContainer);
    // Render
    root.render(<App/>);
}