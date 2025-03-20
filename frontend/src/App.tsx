import { BrowserRouter, Navigate, Route } from "react-router-dom";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";
import { Routes } from "react-router";

import Home from "./pages/Home";
import Result from "./pages/Result";
import PageNotFound from "./pages/PageNotFound";
import Diagnosis from "./pages/Diagnosis";
import AppLayout from "./layouts/AppLayout";
import Feedback from "./pages/Feedback";
import ScrollToTop from "./components/ScrollToTop";

import { Toaster } from "react-hot-toast";
import ScoresContextProvider from "./context/diagnosis-context";

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      // staleTime: 60 * 1000,
      staleTime: 0,
    },
  },
});

function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <ReactQueryDevtools initialIsOpen={false} />
      <ScoresContextProvider>
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
      </ScoresContextProvider>

      <Toaster
        position="top-right"
        gutter={12}
        containerStyle={{ margin: "8px" }}
        toastOptions={{
          success: {
            duration: 3000,
          },
          error: {
            duration: 5000,
          },
          style: {
            fontSize: "16px",
            maxWidth: "500px",
            padding: "16px 24px",
            backgroundColor: "#f5f5f5",
            color: "#262626",
          },
        }}
      />
    </QueryClientProvider>
  );
}

export default App;
