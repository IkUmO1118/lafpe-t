import { lazy, Suspense } from "react";
import { BrowserRouter, Navigate, Route } from "react-router-dom";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { ReactQueryDevtools } from "@tanstack/react-query-devtools";
import { Routes } from "react-router";

import AppLayout from "./layouts/AppLayout";
import ScrollToTop from "./components/ScrollToTop";
import { Toaster } from "react-hot-toast";

// Lazy load pages
const Home = lazy(() => import("./pages/Home"));
const Result = lazy(() => import("./pages/Result"));
const PageNotFound = lazy(() => import("./pages/PageNotFound"));
const Diagnosis = lazy(() => import("./pages/Diagnosis"));
const Feedback = lazy(() => import("./pages/Feedback"));

// Lazy load context provider
const ScoresContextProvider = lazy(
  () => import("./context/ScoresContextProvider"),
);

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: 0,
    },
  },
});

function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <ReactQueryDevtools initialIsOpen={false} />
      <Suspense fallback={<div>Loading...</div>}>
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
      </Suspense>

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
