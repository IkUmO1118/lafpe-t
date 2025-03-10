import { BrowserRouter, Navigate, Route } from "react-router-dom";
import { Routes } from "react-router";
import Home from "./pages/Home";
import Contact from "./pages/Contact";
import Result from "./pages/Result";
import PageNotFound from "./pages/PageNotFound";
import Diagnosis from "./pages/Diagnosis";
import AppLayout from "./layouts/AppLayout";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<AppLayout />}>
          <Route index element={<Navigate replace to="home" />} />
          <Route path="home" element={<Home />} />
          <Route path="contact" element={<Contact />} />
          <Route path="result" element={<Result />} />
          <Route path="*" element={<PageNotFound />} />
        </Route>

        <Route path="diagnosis" element={<Diagnosis />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
