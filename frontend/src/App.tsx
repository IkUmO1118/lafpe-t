import { BrowserRouter, Navigate, Route } from "react-router-dom";
import { Routes } from "react-router";
import Home from "./pages/Home";
import Result from "./pages/Result";
import PageNotFound from "./pages/PageNotFound";
import Diagnosis from "./pages/Diagnosis";
import AppLayout from "./layouts/AppLayout";
import Feedback from "./pages/Feedback";
import ScrollToTop from "./components/ScrollToTop";

function App() {
  return (
    <BrowserRouter>
      <ScrollToTop />
      <Routes>
        <Route element={<AppLayout />}>
          <Route index element={<Navigate replace to="home" />} />
          <Route path="home" element={<Home />} />
          <Route path="feedback" element={<Feedback />} />
          <Route path="result" element={<Result />} />
          <Route path="*" element={<PageNotFound />} />
        </Route>

        <Route path="diagnosis" element={<Diagnosis />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
